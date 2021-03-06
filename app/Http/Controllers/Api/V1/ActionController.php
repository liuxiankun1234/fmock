<?php
/**
 * 用户动作相关
 *
 * @Author huaixiu.zhen
 * http://litblc.com
 * User: z00455118
 * Date: 2018/9/19
 */
namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\ActionService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ActionController extends Controller
{
    private $actionService;

    /**
     * ActionController constructor.
     *
     * @param ActionService $actionService
     */
    public function __construct(ActionService $actionService)
    {
        $this->actionService = $actionService;
    }

    /**
     * 获取我关注的所有文章
     *
     * @Author huaixiu.zhen
     * http://litblc.com
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMyFollowedPosts()
    {
        return $this->actionService->getMyFollowedPosts();
    }

    /**
     * 关注文章
     *
     * @Author huaixiu.zhen
     * http://litblc.com
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function followedPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'uuid' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['message' => $validator->errors()->first()],
                Response::HTTP_BAD_REQUEST
            );
        } else {
            return $this->actionService->followPost($request->get('uuid'));
        }
    }

    /**
     * 取消关注
     *
     * @Author huaixiu.zhen
     * http://litblc.com
     *
     * @param $uuid
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function unFollow($uuid)
    {
        return $this->actionService->unFollow($uuid);
    }

    /**
     * 赞、取消赞(文章)
     *
     * @Author huaixiu.zhen
     * http://litblc.com
     *
     * @param $uuid
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function likePost($uuid)
    {
        return $this->actionService->userAction($uuid, 'like', 'post');
    }

    /**
     * 踩、取消踩(文章)
     *
     * @Author huaixiu.zhen
     * http://litblc.com
     *
     * @param $uuid
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function dislikePost($uuid)
    {
        return $this->actionService->userAction($uuid, 'dislike', 'post');
    }

    /**
     * 查询 当前用户 对该文章是否存在 赞、踩
     * 所有 对内查询 可以使用ID，其他一律使用uuid
     *
     * @Author huaixiu.zhen
     * http://litblc.com
     *
     * @param $uuid
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function statusPost($uuid)
    {
        return $this->actionService->status($uuid, 'post');
    }

    /**
     * 赞、取消赞(评论)
     *
     * @Author huaixiu.zhen
     * http://litblc.com
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function likeComment($id)
    {
        return $this->actionService->userAction($id, 'like', 'comment');
    }

    /**
     * 踩、取消踩(评论)
     *
     * @Author huaixiu.zhen
     * http://litblc.com
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function dislikeComment($id)
    {
        return $this->actionService->userAction($id, 'dislike', 'comment');
    }

    /**
     * 查询 当前用户 对该评论是否存在 赞、踩
     *
     * @Author huaixiu.zhen
     * http://litblc.com
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function statusComment($id)
    {
        return $this->actionService->status($id, 'comment');
    }
}
