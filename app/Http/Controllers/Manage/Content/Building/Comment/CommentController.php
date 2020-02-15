<?php namespace App\Http\Controllers\Manage\Content\Building\Comment;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Building\Comment\TfBuildingComment;
use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelBuildingComment = new TfBuildingComment();
        $dataBuildingComment = TfBuildingComment::where('action', 1)->orderBy('comment_id', 'DESC')->select('*')->paginate(30);
        $accessObject = 'building';
        return view('manage.content.building.comment.list', compact('modelStaff', 'modelBuildingComment', 'dataBuildingComment', 'accessObject'));
    }

    #View post
    public function viewComment($commentId)
    {
        $modelBuilding = new TfBuilding();
        $dataBuildingComment = TfBuildingComment::find($commentId);
        if (count($dataBuildingComment) > 0) {
            return view('manage.content.building.comment.view', compact('modelBuilding', 'dataBuildingComment'));
        }
    }

    #delete post
    public function deleteComment($commentId)
    {
        $modelBuildingComment = new TfBuildingComment();
        return $modelBuildingComment->actionDelete($commentId);
    }

}
