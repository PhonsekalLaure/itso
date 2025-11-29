<?php
namespace App\Controllers;

use App\Models\Equipments_Model;
use App\Models\Users_Model;
use App\Models\Borrows_Model;
use App\Libraries\Html2Pdf;

class Reports extends BaseController {
    protected $equipmentsModel;
    protected $usersModel;
    protected $borrowsModel;

    public function __construct() {
        $this->equipmentsModel = new Equipments_Model();
        $this->usersModel = new Users_Model();
        $this->borrowsModel = new Borrows_Model();
    }

    public function index() {
        if (!session()->get('admin')) {
            return redirect()->to(base_url('auth/login'));
        }

        $data = [
            'title' => 'Users Dashboard',
            'admin' => session()->get('admin'),
            'users'=> $this->usersModel->findAll(),
            'equipments' => [],
            'reservations'=> [],
        ];

        return view('include\head_view', $data)
            .view('include\nav_view')
            .view('reports\reports_view', $data)
            .view('include\foot_view');
    }

    public function activeEquipment() {
        if (!session()->get('admin')) {
            return redirect()->to(base_url('auth/login'));
        }

        try {
            $equipments = $this->equipmentsModel
                ->where('is_deactivated', 0)
                ->findAll();

            $this->generatePDF(
                'Active Equipment Report',
                'ACTIVE_EQUIPMENT_' . date('Y-m-d_H-i-s'),
                $equipments,
                'equipment',
                $this->formatEquipmentData($equipments)
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to generate report: ' . $e->getMessage());
        }
    }

    public function unusableEquipment() {
        if (!session()->get('admin')) {
            return redirect()->to(base_url('auth/login'));
        }

        try {
            $equipments = $this->equipmentsModel
                ->where('is_deactivated', 1)
                ->findAll();

            $this->generatePDF(
                'Unusable Equipment Report',
                'UNUSABLE_EQUIPMENT_' . date('Y-m-d_H-i-s'),
                $equipments,
                'equipment',
                $this->formatEquipmentData($equipments)
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to generate report: ' . $e->getMessage());
        }
    }

    public function borrowingHistory() {
        if (!session()->get('admin')) {
            return redirect()->to(base_url('auth/login'));
        }

        try {
            $userId = $this->request->getPost('user_id');
            $dateFrom = $this->request->getPost('date_from');
            $dateTo = $this->request->getPost('date_to');

            $query = $this->borrowsModel;

            if ($userId) {
                $query = $query->where('user_id', $userId);
            }

            if ($dateFrom) {
                $query = $query->where('borrow_date >=', $dateFrom);
            }

            if ($dateTo) {
                $query = $query->where('borrow_date <=', $dateTo);
            }

            $borrows = $query->findAll();
            $reportTitle = 'User Borrowing History Report';
            $fileName = 'BORROWING_HISTORY_' . date('Y-m-d_H-i-s');

            $formattedData = $this->formatBorrowingData($borrows, $userId, $dateFrom, $dateTo);

            $this->generatePDF(
                $reportTitle,
                $fileName,
                $borrows,
                'borrowing',
                $formattedData
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to generate report: ' . $e->getMessage());
        }
    }

    protected function generatePDF($title, $filename, $data, $reportType, $htmlContent) {
        try {
            $pdf = new Html2Pdf('P', 'mm', 'A4');

            $pdf->setCreator('ITSO System');
            $pdf->setAuthor('Equipment Management System');
            $pdf->setTitle($title);
            $pdf->setSubject($title);

            $pdf->setMargins(15, 15, 15);
            $pdf->setHeaderMargin(5);
            $pdf->setFooterMargin(10);
            $pdf->setAutoPageBreak(true, 25);

            $pdf->addPage();

            // Build complete HTML for PDF
            $finalHtml = '<h1>' . htmlspecialchars($title) . '</h1>';
            $finalHtml .= '<p>Generated on: ' . date('M d, Y H:i:s A') . '</p>';
            $finalHtml .= '<hr style="margin: 10px 0;">';
            $finalHtml .= $htmlContent;

            $pdf->writeHTML($finalHtml);

            $pdf->output($filename, 'D');
        } catch (\Exception $e) {
            log_message('error', 'PDF Generation Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    protected function formatEquipmentData($equipments) {
        if (empty($equipments)) {
            return '<p style="text-align:center; color:#666;">No equipment found.</p>';
        }

        // Table header - use bgcolor for TCPDF compatibility
        $html = '<table border="1" cellpadding="6" cellspacing="0" style="width:100%; border-collapse:collapse; font-size:10px;">';
        $html .= '<tr bgcolor="#0b824a" style="color:#ffffff; font-weight:bold;">';
        $html .= '<th style="width:6%; text-align:center;">ID</th>';
        $html .= '<th style="width:25%;">Equipment Name</th>';
        $html .= '<th style="width:35%;">Description</th>';
        $html .= '<th style="width:12%; text-align:center;">Total Count</th>';
        $html .= '<th style="width:12%; text-align:center;">Available</th>';
        $html .= '<th style="width:10%; text-align:center;">Status</th>';
        $html .= '</tr>';

        foreach ($equipments as $equipment) {
            // be tolerant to different key names
            $id = $equipment['equipment_id'] ?? $equipment['id'] ?? 'N/A';
            $name = $equipment['name'] ?? 'N/A';
            $description = $equipment['description'] ?? 'N/A';
            $total = $equipment['total_count'] ?? $equipment['total'] ?? '0';
            $available = $equipment['available_count'] ?? $equipment['available'] ?? '0';
            $isDeactivated = isset($equipment['is_deactivated']) ? (int)$equipment['is_deactivated'] : 0;

            $status = $isDeactivated ? '<span style="color:#c0392b; font-weight:bold;">Inactive</span>' : '<span style="color:#27ae60; font-weight:bold;">Active</span>';

            $html .= '<tr>';
            $html .= '<td style="text-align:center;">' . htmlspecialchars($id) . '</td>';
            $html .= '<td>' . htmlspecialchars($name) . '</td>';
            $html .= '<td>' . htmlspecialchars($description) . '</td>';
            $html .= '<td style="text-align:center;">' . htmlspecialchars((string)$total) . '</td>';
            $html .= '<td style="text-align:center;">' . htmlspecialchars((string)$available) . '</td>';
            $html .= '<td style="text-align:center;">' . $status . '</td>';
            $html .= '</tr>';
        }

        $html .= '</table>';

        return $html;
    }

    protected function formatBorrowingData($borrows, $userId = null, $dateFrom = null, $dateTo = null) {
        if (empty($borrows)) {
            return '<p style="text-align:center; color:#666;">No borrowing records found.</p>';
        }

        // Filter info block
        $html = '<div style="margin-bottom:8px; font-size:9px; color:#666;">';
        if ($userId) {
            $user = $this->usersModel->find($userId);
            if ($user) {
                $html .= '<p style="margin:2px 0;"><strong>User:</strong> ' . htmlspecialchars(($user['firstname'] ?? '') . ' ' . ($user['lastname'] ?? '')) . '</p>';
            }
        }
        if ($dateFrom) {
            $html .= '<p style="margin:2px 0;"><strong>From Date:</strong> ' . htmlspecialchars($dateFrom) . '</p>';
        }
        if ($dateTo) {
            $html .= '<p style="margin:2px 0;"><strong>To Date:</strong> ' . htmlspecialchars($dateTo) . '</p>';
        }
        $html .= '</div>';

        // Ensure widths sum to ~100%
        $html .= '<table border="1" cellpadding="6" cellspacing="0" style="width:100%; border-collapse:collapse; font-size:9px;">';
        $html .= '<tr bgcolor="#0b824a" style="color:#ffffff; font-weight:bold;">';
        $html .= '<th style="width:8%; text-align:center;">ID</th>';
        $html .= '<th style="width:20%;">User Name</th>';
        $html .= '<th style="width:22%;">Equipment Name</th>';
        $html .= '<th style="width:8%; text-align:center;">Qty</th>';
        $html .= '<th style="width:14%; text-align:center;">Borrow Date</th>';
        $html .= '<th style="width:14%; text-align:center;">Return Date</th>';
        $html .= '<th style="width:14%; text-align:center;">Status</th>';
        $html .= '</tr>';

        foreach ($borrows as $borrow) {
            $borrowId = $borrow['borrow_id'] ?? $borrow['id'] ?? 'N/A';
            $user = $this->usersModel->find($borrow['user_id'] ?? null);
            $equipment = $this->equipmentsModel->find($borrow['equipment_id'] ?? null);

            $userName = $user ? trim(($user['firstname'] ?? '') . ' ' . ($user['lastname'] ?? '')) : 'Unknown';
            $equipmentName = $equipment ? ($equipment['name'] ?? 'Unknown') : 'Unknown';
            $qty = $borrow['quantity'] ?? ($borrow['qty'] ?? '0');
            $borrowDate = $borrow['borrow_date'] ?? 'N/A';
            $returnDate = $borrow['return_date'] ?? 'N/A';
            $rawStatus = $borrow['status'] ?? 'pending';
            $statusLabel = ucfirst($rawStatus);

            // status color
            switch ($rawStatus) {
                case 'returned':
                    $statusColor = '#28a745';
                    break;
                case 'pending':
                    $statusColor = '#ffc107';
                    break;
                case 'overdue':
                    $statusColor = '#dc3545';
                    break;
                default:
                    $statusColor = '#999999';
                    break;
            }

            $html .= '<tr>';
            $html .= '<td style="text-align:center;">' . htmlspecialchars($borrowId) . '</td>';
            $html .= '<td>' . htmlspecialchars($userName) . '</td>';
            $html .= '<td>' . htmlspecialchars($equipmentName) . '</td>';
            $html .= '<td style="text-align:center;">' . htmlspecialchars((string)$qty) . '</td>';
            $html .= '<td style="text-align:center;">' . htmlspecialchars($borrowDate) . '</td>';
            $html .= '<td style="text-align:center;">' . htmlspecialchars($returnDate) . '</td>';
            $html .= '<td style="text-align:center; font-weight:bold; color:' . htmlspecialchars($statusColor) . ';">' . htmlspecialchars($statusLabel) . '</td>';
            $html .= '</tr>';
        }

        $html .= '</table>';

        return $html;
    }
}
