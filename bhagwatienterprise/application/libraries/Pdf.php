<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf
{
    /** @var Dompdf */
    protected $dompdf;

    public function __construct()
    {
        // Load Composer autoload
        // FCPATH is CodeIgniter constant pointing to project root (where index.php sits)
        if (!file_exists(FCPATH . 'vendor/autoload.php')) {
            show_error('Composer autoload not found. Run "composer install" in project root.');
        }
        require_once FCPATH . 'vendor/autoload.php';

        $options = new Options();
        $options->setIsRemoteEnabled(true);          // allow external images/CSS
        $options->set('defaultFont', 'DejaVu Sans'); // good Unicode font
        // optional: $options->setIsHtml5ParserEnabled(true);

        $this->dompdf = new Dompdf($options);
    }

    /**
     * Load HTML into Dompdf.
     */
    public function loadHtml($html)
    {
        $this->dompdf->loadHtml($html);
    }

    /**
     * Set paper size and orientation.
     * Examples: ('A4', 'portrait') or ('A4', 'landscape')
     */
    public function setPaper($size = 'A4', $orientation = 'portrait')
    {
        $this->dompdf->setPaper($size, $orientation);
    }

    /**
     * Render the PDF.
     */
    public function render()
    {
        $this->dompdf->render();
    }

    /**
     * Stream to browser.
     * $options example: ['Attachment' => 1] or ['Attachment' => 0] to open in browser
     */
    public function stream($filename = 'document.pdf', $options = [])
    {
        $this->dompdf->stream($filename, $options);
    }

    /**
     * Return raw output (string) if needed.
     */
    public function output()
    {
        return $this->dompdf->output();
    }
}
