<?php
/*
 * This file is part of the IAKPress package.
 *
 * (c) Joosorol 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace App\Joosorol\IAKPress\Utils;

use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\PostUtils;

class FileUploader
{

    const FILE_END_STR = '_file';

    public static function upload(array &$requestData)
    {
        if ($_FILES) {
            $FILES_TO_UPLOAD = $_FILES;

            foreach ($FILES_TO_UPLOAD as $fieldname => $file) {
                $cleanFieldname = str_replace(self::FILE_END_STR, '', $fieldname);

                // modify $_FILES to make wordpress happy
                $_FILES = array($fieldname => $file);
                foreach ($_FILES as $file => $array) {
                    // upload data
                    $attachId = self::handleUpload($file);

                    if (intval($attachId) != 0) {
                        // get and save url
                        $url = wp_get_attachment_url($attachId);
                        $requestData[$cleanFieldname] = $url;

                        $mediaIdFieldName = PostUtils::getInstance()->buildMediaIdFieldName($cleanFieldname);

                        $requestData[$mediaIdFieldName] = $attachId;
                    } else {
                        // an upload error occured.
                        // TODO handle me
                    }           
                }
            }
        }
    }

    /**
     * Handle Upload
     * @param string $filename
     * @param integer $postId
     * @param bool setThumbnail
     */
    private static function handleUpload(
        $filename, $postId = 0, $setThumbnail = false) {
        require_once ABSPATH . "wp-admin" . '/includes/image.php';
        require_once ABSPATH . "wp-admin" . '/includes/file.php';
        require_once ABSPATH . "wp-admin" . '/includes/media.php';

        $attachId = media_handle_upload($filename, $postId);
        if (is_wp_error($attachId)) {
            return 0;
        }

        if ($setThumbnail) {
            set_post_thumbnail($postId, $attachId);
        }

        return $attachId;
    }
}
