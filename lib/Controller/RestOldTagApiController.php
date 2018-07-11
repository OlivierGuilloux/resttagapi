<?php
namespace OCA\RestTagApi\Controller;

use OC\Files\Filesystem;

use OCP\AppFramework\Http;
use OCP\AppFramework\ApiController;
use OCP\Files\File;
use OCP\Files\NotFoundException;
use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;


/**
 * Class ApiController
 *
 * @package OCA\RestTagApi\Controller
 */
class RestOldTagApiController extends ApiController {

    /** @var string */
    private $userId;

    /** var \OCP\ITagManager */
    private $tagManager;

	/**
	 * @param string $appName
	 * @param IRequest $request
	 * @param TagManager $tagManager
	 */
	public function __construct($appName,
								IRequest $request,
                                \OCP\ITagManager $tagManager,
								$userId) {
		parent::__construct($appName, $request);
        $this->tagManager = $tagManager;
        $this->userId = $userId;
	}


    /**
     * Returns the tagger
     *
     * @return \OCP\ITags tagger
     */
    private function getTagger() {
        if (!$this->tagger) {
            $this->tagger = $this->tagManager->load('files');
        }
        return $this->tagger;
    }

	/**
	 * Updates the info of the specified file path
	 * The passed tags are absolute, which means they will
	 * replace the actual tag selection.
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 * @StrictCookieRequired
	 *
	 * @param string $path path
	 * @param array $tags array of tags name
	 * @return DataResponse
	 */
	public function updateFileTags($path, $tags = null) {
        $node = Filesystem::getView()->getFileInfo($path);
        if($node) {
            $fileId = $node->getId();
            $tagger = $this->getTagger();
            $currentTags =  $tagger->getTagsForObjects(array($fileId)); 

            $newTags = array_diff($tags, $currentTags);
            foreach ($newTags as $tag) {
                $tagger->tagAs($fileId, $tag);
            }
            $deletedTags = array_diff($currentTags, $tags);
            foreach ($deletedTags as $tag) {
                $tagger->unTag($fileId, $tag);
            }
            $current = $tagger->getTagsForObjects(array($fileId));
            return new DataResponse($current);
        }else {
            return new DataResponse("Not found \"$path\"");
        }
	}
    /**
     * Return tag name for the given path
     *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 * @StrictCookieRequired
     */
	public function getFileTags($path) {
        $node = Filesystem::getView()->getFileInfo($path);
        $fileId = $node->getId();
        $tagger = $this->getTagger();
        $current = $tagger->getTagsForObjects(array($fileId)); 
        return new DataResponse($current);
    }
	/**
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 * @StrictCookieRequired
	 *
	 * @param string $path path
	 * @param array|string $tags array of tags
	 * @return DataResponse
	 */
	public function doecho($path, $tags = null) {
        return new DataResponse($path);
    }
    /**
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 *
	 * @return DataResponse
	 */
	public function doecho2() {
        return new DataResponse("Hello");
    }
	
}
