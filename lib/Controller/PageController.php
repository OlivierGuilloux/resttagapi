<?php
namespace OCA\RestTagApi\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\ContentSecurityPolicy;

use OCA\RestTagApi\Service\DBTagService;

class PageController extends Controller {
    /** @var string */
	private $userId;

    /** var \OCP\ITagManager */
    private $tagManager;

    /** var \OCP\SystemTag\ISystemTagObjectMapper */
    private $tagMapper;

	/**
	 * @var DBTagService
	 */
	protected $dbTag;


	/**
	 * @param string $appName
	 * @param IRequest $request
	 * @param ISystemTagManager $tagManager
	 * @param ISystemTagObjectMapper $tagMapper
	 * @param DBTagService $dbTagService
	 */
	public function __construct(
        $AppName, 
        IRequest $request, 
        \OCP\SystemTag\ISystemTagManager $tagManager,
        \OCP\SystemTag\ISystemTagObjectMapper $tagMapper,
        DBTagService $dbTagService,
        $UserId){
		parent::__construct($AppName, $request);
        $this->tagManager = $tagManager;
        $this->tagMapper = $tagMapper;
        $this->dbTag = $dbTagService;
		$this->userId = $UserId;
	}

	/**
	 * CAUTION: the @Stuff turns off security checks; for this page no admin is
	 *          required and no CSRF check. If you don't know what CSRF is, read
	 *          it up in the docs or you might create a security hole. This is
	 *          basically the only required method to add this exemption, don't
	 *          add it to any other method if you don't exactly know what it does
	 *
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index() {
        $data = array(
            'tagsStats'=> $this->dbTag->getTagsStats()
        );
		$response = new TemplateResponse('resttagapi', 'index', $data);  // templates/index.php
		$policy = new ContentSecurityPolicy();
		$policy->addAllowedChildSrcDomain('\'self\'');
		$policy->addAllowedFontDomain('data:');
		$policy->addAllowedImageDomain('*');
		$policy->allowEvalScript(false);
		$response->setContentSecurityPolicy($policy);
		return $response;
	}

}
