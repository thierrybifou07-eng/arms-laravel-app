<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AuditExportService
{
    /**
     * Export audits as CSV.
     */
    public function exportCsv(Collection $audits): StreamedResponse
    {
        $filename = 'audits_' . now()->format('Y-m-d_H-i-s') . '.csv';

        return response()->streamDownload(function () use ($audits) {
            $handle = fopen('php://output', 'w');

            // Write headers
            fputcsv($handle, [
                'ID',
                'User',
                'Action',
                'Model',
                'Event',
                'Old Values',
                'New Values',
                'IP Address',
                'URL',
                'User Agent',
                'Tags',
                'Date',
            ]);

            // Write data
            foreach ($audits as $audit) {
                fputcsv($handle, [
                    $audit->id,
                    $audit->user ? $audit->user->email : 'N/A',
                    $audit->event,
                    class_basename($audit->auditable_type),
                    $audit->event,
                    $this->formatJson($audit->old_values),
                    $this->formatJson($audit->new_values),
                    $audit->ip_address,
                    $audit->url,
                    substr($audit->user_agent, 0, 100),
                    $audit->tags,
                    $audit->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    /**
     * Export audits as Excel.
     */
    public function exportExcel(Collection $audits): StreamedResponse
    {
        // For now, we'll use CSV export for Excel
        // In production, consider using maatwebsite/excel package
        $filename = 'audits_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        return response()->streamDownload(function () use ($audits) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM for Excel compatibility
            fwrite($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Write headers
            fputcsv($handle, [
                'ID',
                'User',
                'Action',
                'Model',
                'Event',
                'Old Values',
                'New Values',
                'IP Address',
                'URL',
                'User Agent',
                'Tags',
                'Date',
            ]);

            // Write data
            foreach ($audits as $audit) {
                fputcsv($handle, [
                    $audit->id,
                    $audit->user ? $audit->user->email : 'N/A',
                    $audit->event,
                    class_basename($audit->auditable_type),
                    $audit->event,
                    $this->formatJson($audit->old_values),
                    $this->formatJson($audit->new_values),
                    $audit->ip_address,
                    $audit->url,
                    substr($audit->user_agent, 0, 100),
                    $audit->tags,
                    $audit->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    /**
     * Format JSON data for display.
     */
    protected function formatJson($data): string
    {
        if (!$data) {
            return '';
        }

        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        if (is_array($data)) {
            return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }

        return (string) $data;
    }
}
