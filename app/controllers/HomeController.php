<?php

namespace App\Controllers;

class HomeController
{
    private $db;

    public function __construct($db)
    {
        if (!$db) {
            throw new \Exception("Database connection not provided");
        }
        $this->db = $db;
    }

    public function index()
    {
        // Get blood inventory levels
        $bloodLevels = $this->getBloodInventoryLevels();

        // Get upcoming events (next 3)
        $upcomingEvents = $this->getUpcomingEvents(3);

        // Get latest news (next 3)
        $latestNews = $this->getLatestNews(3);

        // Get FAQs (limit to 5)
        $faqs = $this->getFaqs(5);

        // Get donation stats
        $donationStats = $this->getDonationStats();

        // Make data available to the view
        $data = [
            'bloodLevels' => $bloodLevels,
            'upcomingEvents' => $upcomingEvents,
            'latestNews' => $latestNews,
            'faqs' => $faqs,
            'donationStats' => $donationStats
        ];

        // Set content path for the layout
        $content = '../app/views/home/index.php';

        // Include the ClientLayout which will use the $content variable
        require_once '../app/views/layouts/ClientLayout/ClientLayout.php';
    }

    private function getBloodInventoryLevels()
    {
        try {
            // Initialize default blood levels
            $bloodLevels = [
                'A' => 0,
                'B' => 0,
                'O' => 0,
                'AB' => 0
            ];

            // Query to get current blood levels as percentages of optimal levels
            $query = "SELECT 
                        blood_type,
                        (COALESCE(SUM(quantity), 0) / CASE 
                            WHEN blood_type = 'O' THEN 100  -- O is universal donor, so need more
                            WHEN blood_type = 'A' THEN 80
                            WHEN blood_type = 'B' THEN 70
                            WHEN blood_type = 'AB' THEN 50  -- AB is universal recipient, so need less
                            ELSE 100
                        END) * 100 as level_percentage
                    FROM blood_inventory
                    WHERE expiration_date > NOW()
                    GROUP BY blood_type";

            $stmt = $this->db->prepare($query);
            $stmt->execute();

            $results = $stmt->get_result();

            while ($row = $results->fetch_assoc()) {
                $bloodType = $row['blood_type'];
                $percentage = min(100, round($row['level_percentage'])); // Cap at 100%
                $bloodLevels[$bloodType] = $percentage;
            }

            return $bloodLevels;
        } catch (\Exception $e) {
            // In case of error, return default values
            return [
                'A' => 0,
                'B' => 0,
                'O' => 0,
                'AB' => 0
            ];
        }
    }
    private function getUpcomingEvents($limit = 3)
    {
        try {
            $query = "SELECT 
                        id, 
                        name as name, 
                        event_date as date, 
                        event_start_time as time, 
                        donation_unit_id,
                        current_registrations,
                        max_registrations,
                        status,
                        description
                    FROM event
                    WHERE event_date >= CURDATE() AND status = 1
                    ORDER BY event_date ASC, event_start_time ASC
                    LIMIT ?";

            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $limit);
            $stmt->execute();

            $results = $stmt->get_result();
            $events = [];

            while ($row = $results->fetch_assoc()) {
                // Get donation unit location
                $locationQuery = "SELECT name, location FROM donation_unit WHERE id = ?";
                $locationStmt = $this->db->prepare($locationQuery);
                $locationStmt->bind_param("i", $row['donation_unit_id']);
                $locationStmt->execute();
                $locationResult = $locationStmt->get_result();
                $locationData = $locationResult->fetch_assoc();

                if ($locationData) {
                    $row['location'] = $locationData['name'] . ' - ' . $locationData['address'];
                }

                $events[] = $row;
            }

            return $events;
        } catch (\Exception $e) {
            // In case of error, return empty array
            return [];
        }
    }

    private function getLatestNews($limit = 3)
    {
        try {
            $query = "SELECT 
                        id, 
                        title, 
                        content, 
                        author,
                        timestamp as created_at,
                        image_url as image
                    FROM news 
                    ORDER BY timestamp DESC
                    LIMIT ?";

            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $limit);
            $stmt->execute();

            $results = $stmt->get_result();
            $news = [];

            while ($row = $results->fetch_assoc()) {
                // Create a shorter summary from content
                $row['summary'] = substr(strip_tags($row['content']), 0, 150) . '...';
                $news[] = $row;
            }

            return $news;
        } catch (\Exception $e) {
            // In case of error, return empty array
            return [];
        }
    }

    private function getFaqs($limit = 5)
    {
        try {
            $query = "SELECT 
                        id, 
                        question, 
                        answer
                    FROM faqs 
                    ORDER BY id ASC
                    LIMIT ?";

            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $limit);
            $stmt->execute();

            $results = $stmt->get_result();
            $faqs = [];

            while ($row = $results->fetch_assoc()) {
                $faqs[] = $row;
            }

            return $faqs;
        } catch (\Exception $e) {
            // In case of error, return empty array
            return [];
        }
    }


    private function getDonationStats()
    {
        try {
            // Get total donors
            $totalDonorsQuery = "SELECT COUNT(DISTINCT user_id) as total FROM blood_donation_history";
            $totalDonorsStmt = $this->db->prepare($totalDonorsQuery);
            $totalDonorsStmt->execute();
            $totalDonorsResult = $totalDonorsStmt->get_result();
            $totalDonors = $totalDonorsResult->fetch_assoc()['total'] ?? 0;

            // Get total donations
            $totalDonationsQuery = "SELECT COUNT(*) as total FROM blood_donation_history";
            $totalDonationsStmt = $this->db->prepare($totalDonationsQuery);
            $totalDonationsStmt->execute();
            $totalDonationsResult = $totalDonationsStmt->get_result();
            $totalDonations = $totalDonationsResult->fetch_assoc()['total'] ?? 0;

            // Get total units collected
            $totalUnitsQuery = "SELECT SUM(quantity) as total FROM blood_donation_history";
            $totalUnitsStmt = $this->db->prepare($totalUnitsQuery);
            $totalUnitsStmt->execute();
            $totalUnitsResult = $totalUnitsStmt->get_result();
            $totalUnits = $totalUnitsResult->fetch_assoc()['total'] ?? 0;

            // Get donations this month
            $currentMonthQuery = "SELECT COUNT(*) as total FROM blood_donation_history 
                                WHERE MONTH(donation_date) = MONTH(CURRENT_DATE()) 
                                AND YEAR(donation_date) = YEAR(CURRENT_DATE())";
            $currentMonthStmt = $this->db->prepare($currentMonthQuery);
            $currentMonthStmt->execute();
            $currentMonthResult = $currentMonthStmt->get_result();
            $currentMonthDonations = $currentMonthResult->fetch_assoc()['total'] ?? 0;

            return [
                'totalDonors' => $totalDonors,
                'totalDonations' => $totalDonations,
                'totalUnits' => $totalUnits,
                'currentMonthDonations' => $currentMonthDonations
            ];
        } catch (\Exception $e) {
            // In case of error, return default values
            return [
                'totalDonors' => 1200,
                'totalDonations' => 3500,
                'totalUnits' => 5000,
                'currentMonthDonations' => 150
            ];
        }
    }
}
