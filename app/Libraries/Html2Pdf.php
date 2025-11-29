<?php
/**
 * Lightweight PDF Generator using wkhtmltopdf
 * No Composer dependency - Uses system command
 * Alternative: use DomPDF or mPDF without Composer
 */

namespace App\Libraries;

class Html2Pdf
{
    private $pageWidth = 210;   // A4 width in mm
    private $pageHeight = 297;  // A4 height in mm
    private $marginLeft = 15;
    private $marginTop = 15;
    private $marginRight = 15;
    private $marginBottom = 25;
    private $title = '';
    private $creator = '';
    private $author = '';
    private $subject = '';
    private $htmlContent = '';

    public function __construct($orientation = 'P', $unit = 'mm', $pageSize = 'A4')
    {
        // Initialize
    }

    public function setCreator($creator)
    {
        $this->creator = $creator;
        return $this;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function setMargins($left, $top, $right)
    {
        $this->marginLeft = $left;
        $this->marginTop = $top;
        $this->marginRight = $right;
        return $this;
    }

    public function setHeaderMargin($margin)
    {
        $this->marginTop = $margin;
        return $this;
    }

    public function setFooterMargin($margin)
    {
        $this->marginBottom = $margin;
        return $this;
    }

    public function setAutoPageBreak($auto, $margin = 0)
    {
        // Not needed for simple HTML rendering
        return $this;
    }

    public function addPage()
    {
        // Handled internally
        return $this;
    }

    public function setFont($fontFamily = '', $style = '', $size = 0)
    {
        // Handled in HTML styling
        return $this;
    }

    public function cell($width, $height, $text, $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        // Handled by HTML rendering
        return $this;
    }

    public function ln($height = null)
    {
        // Handled by HTML rendering
        return $this;
    }

    /**
     * Write HTML content
     */
    public function writeHTML($html)
    {
        $this->htmlContent = $html;
        return $this;
    }

    /**
     * Output PDF - converts HTML to PDF
     */
    public function output($filename = '', $dest = 'D')
    {
        if (empty($filename)) {
            $filename = 'document.pdf';
        }

        if (substr($filename, -4) !== '.pdf') {
            $filename .= '.pdf';
        }

        // Build complete HTML document
        $html = $this->buildDocument();

        // Try wkhtmltopdf first
        if ($this->hasWkhtmltopdf()) {
            return $this->convertWithWkhtmltopdf($html, $filename, $dest);
        }

        // Fallback: Save HTML as downloadable document
        return $this->downloadAsHtml($html, $filename, $dest);
    }

    /**
     * Save to file
     */
    public function save($filepath)
    {
        return $this->output($filepath, 'F');
    }

    private function buildDocument()
    {
        $html = '<!DOCTYPE html>';
        $html .= '<html><head>';
        $html .= '<meta charset="UTF-8">';
        $html .= '<meta name="creator" content="' . htmlspecialchars($this->creator) . '">';
        $html .= '<meta name="author" content="' . htmlspecialchars($this->author) . '">';
        $html .= '<title>' . htmlspecialchars($this->title) . '</title>';
        $html .= '<style>';
        $html .= 'body { font-family: Arial, sans-serif; margin: ' . $this->marginTop . 'mm ' . $this->marginRight . 'mm ' . $this->marginBottom . 'mm ' . $this->marginLeft . 'mm; }';
        $html .= 'table { width: 100%; border-collapse: collapse; margin: 10px 0; font-size: 9px; }';
        $html .= 'th, td { border: 1px solid #333; padding: 6px; }';
        $html .= 'th { background-color: #0b824a; color: white; font-weight: bold; }';
        $html .= 'h1 { text-align: center; font-size: 16px; margin: 0 0 5px 0; }';
        $html .= 'p { text-align: center; font-size: 10px; color: #666; margin: 0; }';
        $html .= '</style>';
        $html .= '</head><body>';
        $html .= $this->htmlContent;
        $html .= '</body></html>';
        return $html;
    }

    private function hasWkhtmltopdf()
    {
        $cmd = 'where wkhtmltopdf';
        $output = shell_exec($cmd);
        return !empty($output);
    }

    private function convertWithWkhtmltopdf($html, $filename, $dest)
    {
        $tempHtml = tempnam(sys_get_temp_dir(), 'pdf_');
        $tempPdf = str_replace('.tmp', '.pdf', $tempHtml);

        file_put_contents($tempHtml, $html);

        // Use wkhtmltopdf to convert
        $cmd = sprintf(
            'wkhtmltopdf --quiet "%s" "%s" 2>&1',
            escapeshellarg($tempHtml),
            escapeshellarg($tempPdf)
        );

        exec($cmd, $output, $returnCode);

        if ($returnCode !== 0 || !file_exists($tempPdf)) {
            @unlink($tempHtml);
            throw new \Exception('PDF generation failed: ' . implode(' ', $output));
        }

        $pdf = file_get_contents($tempPdf);

        @unlink($tempHtml);
        @unlink($tempPdf);

        if ($dest === 'D') {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . addslashes($filename) . '"');
            echo $pdf;
            exit;
        } elseif ($dest === 'F') {
            file_put_contents($filename, $pdf);
        } else {
            header('Content-Type: application/pdf');
            echo $pdf;
            exit;
        }

        return $filename;
    }

    private function downloadAsHtml($html, $filename, $dest)
    {
        // Fallback if wkhtmltopdf not available
        // Save as HTML file instead
        if ($dest === 'D') {
            header('Content-Type: text/html; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . str_replace('.pdf', '.html', $filename) . '"');
            echo $html;
            exit;
        } elseif ($dest === 'F') {
            file_put_contents(str_replace('.pdf', '.html', $filename), $html);
        }

        return str_replace('.pdf', '.html', $filename);
    }
}
