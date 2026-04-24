<?php

use App\Models\Link;
use Illuminate\Support\Facades\Auth;

/**
 * Handles the logic for the QR code contact block.
 *
 * @param \Illuminate\Http\Request $request
 * @param mixed $linkType
 * @param bool $processUpload
 * @return array
 */
function handleLinkType($request, $linkType, $processUpload = true)
{
    $rules = [
        'title' => [
            'required',
            'string',
            'max:255',
        ],
        'button_id' => [
            'required',
            'integer',
            'exists:buttons,id',
        ],
        'qr_description' => [
            'nullable',
            'string',
            'max:500',
        ],
        'qr_image' => [
            $request->filled('current_qr_image') ? 'nullable' : 'required',
            'image',
            'mimes:png,jpg,jpeg,webp',
            'max:4096',
        ],
    ];

    $qrImagePath = $request->input('current_qr_image', '');

    if ($processUpload && $request->hasFile('qr_image')) {
        $uploadDir = base_path('assets/img/qrcodes');
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $existingLink = $request->filled('linkid') ? Link::find($request->linkid) : null;
        if ($existingLink && !empty($existingLink->type_params)) {
            $existingParams = json_decode($existingLink->type_params, true);
            $existingPath = $existingParams['qr_image_path'] ?? null;
            $fullExistingPath = $existingPath ? base_path($existingPath) : null;

            if ($fullExistingPath && file_exists($fullExistingPath) && str_contains(str_replace('\\', '/', $fullExistingPath), '/assets/img/qrcodes/')) {
                @unlink($fullExistingPath);
            }
        }

        $extension = $request->file('qr_image')->extension();
        $fileName = 'qr_' . Auth::id() . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
        $request->file('qr_image')->move($uploadDir, $fileName);
        $qrImagePath = 'assets/img/qrcodes/' . $fileName;
    }

    $linkData = [
        'link' => '#',
        'title' => $request->title,
        'button_id' => (int) $request->button_id,
        'qr_description' => $request->qr_description ?? '',
        'qr_image_path' => $qrImagePath,
    ];

    return ['rules' => $rules, 'linkData' => $linkData];
}
