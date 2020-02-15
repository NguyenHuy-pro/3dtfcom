<?php namespace App\Http\Controllers\Manage\Content\Building\PostComment;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\Building\PostComment\TfBuildingPostComment;

use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelBuildingPostComment = new TfBuildingPostComment();
        $dataPostComment = TfBuildingPostComment::where('action', 1)->orderBy('comment_id', 'DESC')->select('*')->paginate(30);
        $accessObject = 'post';
        return view('manage.content.building.post-comment.list', compact('modelStaff', 'modelBuildingPostComment', 'dataPostComment', 'accessObject'));
    }

    #View post
    public function viewComment($commentId)
    {
        $modelPostComment = new TfBuildingPostComment();
        $dataPostComment = $modelPostComment->getInfo($commentId);
        if (count($dataPostComment) > 0) {
            return view('manage.content.building.post-comment.view', compact('dataPostComment'));
        }
    }

    #delete post
    public function deleteComment($commentId)
    {
        $modelPostComment = new TfBuildingPostComment();
        return $modelPostComment->getDelete($commentId);
    }

}
