<?php

/*
 * This file is part of Joosorol package.
 *
 * (c) Joosorol 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Joosorol\IAKPress\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use App\Joosorol\IAKPress\IAPost\BaseController;
use App\Joosorol\IAKPress\IAPost\Constants;
use App\Joosorol\IAKPress\IAPost\PluginInterface;

use App\Joosorol\IAKPress\IAPost\PostUtils;

/**
 * Description of FormStatusController
 *
 * @author bly
 */
class FormStatusController extends BaseController {
    /**
     * @Route("/iakpress/dash/entries/{entryId}/setstatus", name="dash_set_message_status", methods={"HEAD", "POST","OPTIONS"})
     */
    public function setEntryStatus(Request $request, int $entryId) {
        if (!PluginInterface::getInstance()->getUserCanManage()) {
            return $this->accessDenied();
        }

        $res = PostUtils::getInstance()->setStatus($entryId, $request->request->all());

        if (is_null($res)) {
            return $this->notFound();
        }

        return new JsonResponse($res);
    }

    /**
     * @Route("/iakpress/dash/entries/status/{statusId}/count", name="dash_count_entries_by_status_id", methods={"HEAD","GET","OPTIONS"})
     */
    public function countEntriesByStatusId(Request $request, string $statusId) {
        if (!PluginInterface::getInstance()->getUserCanManage()) {
            return $this->accessDenied();
        }

        $res = PostUtils::getInstance()->countEntriesByStatusId($statusId);

        if (is_null($res)) {
            return $this->notFound();
        }

        return new JsonResponse([
            Constants::COUNT => $res
        ]);
    }
}
