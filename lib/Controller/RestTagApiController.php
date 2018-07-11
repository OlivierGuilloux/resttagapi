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
class RestTagApiController extends ApiController {

    /** @var string */
    private $userId;

    /** var \OCP\ITagManager */
    private $tagManager;

    /** var \OCP\SystemTag\ISystemTagObjectMapper */
    private $tagMapper;

	/**
	 * @param string $appName
	 * @param IRequest $request
	 * @param ISystemTagManager $tagManager
	 * @param ISystemTagObjectMapper $tagMapper
	 */
	public function __construct($appName,
								IRequest $request,
                                \OCP\SystemTag\ISystemTagManager $tagManager,
                                \OCP\SystemTag\ISystemTagObjectMapper $tagMapper,
								$userId) {
		parent::__construct($appName, $request);
        $this->tagManager = $tagManager;
        $this->tagMapper = $tagMapper;
        $this->userId = $userId;
	}


    /**
     * Returns the tagIds for the given tags name list
     * create tag if necessary
     *
	 * @param array  $tags array of tags name
     * @return array tagIds
     */
    private function getTagIds($tags) {
        $tagIds = [];
        foreach ($tags as $tag) {
            // Create systemtag if not exisits
            try {
                $existingTag = $this->tagManager->getTag($tag, true, true);
                $tagIds[] = $existingTag->getId();
            }
            catch (\OCP\SystemTag\TagNotFoundException $e){
                $newTag = $this->tagManager->createTag($tag, true, true);
                $tagIds[] = $newTag->getId();
            }
        }
        return $tagIds;
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
	 * @param array  $tags array of tags name
	 * @return DataResponse
	 */
	public function updateFileTags($path, $tags = null) {
        // get node from path
        $node = Filesystem::getView()->getFileInfo($path);
        // set file id
        if($node) {
            $fileId = $node->getId();
            // TODO : improve
            $fileType = "files"; //$node->getType();
            // Cleanup tags
            $fileTags = $this->tagMapper->getTagIdsForObjects($fileId, $fileType);
            if($fileTags) {
                $this->tagMapper->unassignTags($fileId, $fileType, $fileTags[$fileId]);
            }
            // assign new tags
            $tagIds = $this->getTagIds($tags);
            $this->tagMapper->assignTags($fileId, $fileType, $tagIds);
            return new DataResponse($this->tagMapper->getTagIdsForObjects($fileId, $fileType));
        }
        return new DataResponse("Not found \"$path\"");
	}
    /**
     * Return tagIds for the given path
     * 
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 * @StrictCookieRequired
     *
	 * @param string $path path
	 * @return DataResponse
     */
	public function getFileTags($path) {
        $node = Filesystem::getView()->getFileInfo($path);
        // TODO : improve
        $fileType = "files"; //$node->getType();
        return new DataResponse($this->tagMapper->getTagIdsForObjects($node->getId(), $fileType));
    }
}
