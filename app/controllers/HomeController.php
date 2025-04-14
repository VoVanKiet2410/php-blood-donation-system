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
        $content = function () use ($data) {
            extract($data);
            require_once '../app/views/home/index.php';
        };
        require_once '../app/views/layouts/ClientLayout/ClientLayout.php';
    }

    private function getBloodInventoryLevels()
    {
        try {
            // Initialize default blood levels for all possible types
            $bloodLevels = [
                'A+' => 0,
                'A-' => 0,
                'B+' => 0,
                'B-' => 0,
                'O+' => 0,
                'O-' => 0,
                'AB+' => 0,
                'AB-' => 0
            ];

            // Query to get current blood levels as percentages of optimal levels
            $query = "SELECT 
                        blood_type,
                        (COALESCE(SUM(quantity), 0) / CASE 
                            WHEN blood_type = 'O+' OR blood_type = 'O-' THEN 100
                            WHEN blood_type = 'A+' OR blood_type = 'A-' THEN 80
                            WHEN blood_type = 'B+' OR blood_type = 'B-' THEN 70
                            WHEN blood_type = 'AB+' OR blood_type = 'AB-' THEN 50
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
                // Only set if blood type exists in $bloodLevels
                if (array_key_exists($bloodType, $bloodLevels)) {
                    $bloodLevels[$bloodType] = $percentage;
                }
            }
            return $bloodLevels;
        } catch (\Exception $e) {
            return [
                'A+' => 0,
                'A-' => 0,
                'B+' => 0,
                'B-' => 0,
                'O+' => 0,
                'O-' => 0,
                'AB+' => 0,
                'AB-' => 0
            ];
        }
    }
    private function getUpcomingEvents($limit = 3)
    {
        try {
            $query = "SELECT 
                        e.id, 
                        e.name as name, 
                        e.event_date as date, 
                        e.event_start_time as time, 
                        e.donation_unit_id,
                        e.current_registrations,
                        e.max_registrations,
                        e.status,
                        du.name as unit_name,
                        du.location as location,
                        du.phone as unit_phone,
                        du.email as unit_email,
                        du.unit_photo_url as unit_photo_url
                    FROM event e
                    LEFT JOIN donation_unit du ON e.donation_unit_id = du.id
                    WHERE e.event_date >= CURDATE() AND e.status = 1
                    ORDER BY e.event_date ASC, e.event_start_time ASC
                    LIMIT ?";

            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $limit);
            $stmt->execute();
            $results = $stmt->get_result();
            $events = [];
            while ($row = $results->fetch_assoc()) {
                $events[] = $row;
            }
            return $events;
        } catch (\Exception $e) {
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
                        title, 
                        description 
                    FROM faq
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
            $totalUnitsQuery = "SELECT SUM(quantity) as total FROM blood_inventory";
            $totalUnitsStmt = $this->db->prepare($totalUnitsQuery);
            $totalUnitsStmt->execute();
            $totalUnitsResult = $totalUnitsStmt->get_result();
            $totalUnits = $totalUnitsResult->fetch_assoc()['total'] ?? 0;

            // Get donations this month
            $currentMonthQuery = "SELECT COUNT(*) as total FROM blood_donation_history 
                                WHERE MONTH(donation_date_time ) = MONTH(CURRENT_DATE()) 
                                AND YEAR(donation_date_time ) = YEAR(CURRENT_DATE())";
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
