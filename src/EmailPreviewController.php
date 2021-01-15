<?php

namespace KafeinStudio\EmailPreview;


use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Filesystem\Filesystem;

class EmailPreviewController
{
    /**
     * @return string
     */
    public function list()
    {
        $this->cleanOldPreviews();

        $emails = glob(config('emailpreview.path') . '/*.html');

        return view('laravel-email-preview::directory_listing', compact('emails'));
    }


    /**
     * @param String $emailName
     * @return string
     */
    public function show(string $emailName): string
    {
        return file_get_contents(config('emailpreview.path') . '/' . $emailName . '.html');
    }


    /**
     * @param String $emailName
     * @return string
     */
    public function download(string $emailName): string
    {
        $file = config('emailpreview.path') . '/' . $emailName . '.eml';

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }

        abort(404);
    }


    /**
     * Delete previews older than the given life time configuration.
     *
     * @return void
     */
    private function cleanOldPreviews(): void
    {
        try {
            $files = app()->make(Filesystem::class);
        } catch (BindingResolutionException $e) {
            return;
        }

        $oldPreviews = array_filter($files->files(config('emailpreview.path')), function ($file) use ($files) {
            return time() - $files->lastModified($file) > config('emailpreview.lifeTime');
        });

        if ($oldPreviews) {
            $files->delete($oldPreviews);
        }
    }
}
