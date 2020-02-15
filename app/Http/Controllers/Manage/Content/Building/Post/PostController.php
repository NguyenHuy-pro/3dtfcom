<?php namespace App\Http\Controllers\Manage\Content\Building\Post;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Building\Post\TfBuildingPost;
use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelBuilding = new TfBuilding();
        $modelBuildingPost = new TfBuildingPost();
        $dataBuildingPost = TfBuildingPost::where('action', 1)->orderBy('post_id', 'DESC')->select('*')->paginate(30);
        $accessObject = 'post';
        return view('manage.content.building.post.list', compact('modelStaff', 'modelBuilding', 'modelBuildingPost', 'dataBuildingPost', 'accessObject'));
    }

    #View post
    public function viewPost($postId)
    {
        $modelBuilding = new TfBuilding();
        $modelBuildingPost = new TfBuildingPost();
        $dataBuildingPost = $modelBuildingPost->getInfo($postId);
        if (count($dataBuildingPost) > 0) {
            return view('manage.content.building.post.view', compact('modelBuilding', 'dataBuildingPost'));
        }
    }

    #delete post
    public function deletePost($postId)
    {
        $modelBuildingPost = new TfBuildingPost();
        return $modelBuildingPost->getDelete($postId);
    }

}
