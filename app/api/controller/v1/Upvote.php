<?php


namespace app\api\controller\v1;

use app\admin\model\EntUserNews;

/**
 * 用户点赞
 * Class Upvote
 * @package app\api\controller\v1
 */
class Upvote extends AuthBase
{
    // 点赞
    public function save()
    {
        $id = input('post.id');
        if(empty($id)){
            return show(1,'success','ID不合法',403);
        }

        $data = [
            'user_id' => $this->user['id'],
            'news_id' => $id
        ];

        $isUpvote = EntUserNews::where($data)->find();

        if($isUpvote){
            return show(0,'error','您已经点赞过了，不能重复点赞');
        }

        try {
            $EntUserNewsId = (new EntUserNews())->add($data);
            if($EntUserNewsId){
                \app\admin\model\News::where('id',$id)->inc('upvote_count')->update();
                return show(1,'success','点赞成功');
            }

            return show(0,'error','点赞失败');
        }catch (\Exception $e){
            return show(0,$e->getMessage(),[],'403');
        }
    }

    // 取消点赞
    public function delete()
    {
        $id = input('post.id');

        if(empty($id)){
            return show(1,'success','ID不合法',403);
        }

        $data = [
            'user_id' => $this->user['id'],
            'news_id' => $id
        ];

        $isUpvote = EntUserNews::where($data)->find();

        if(empty($isUpvote)){
            return show(0,'error','没有被点赞，不能取消');
        }

        try {
            $EntUserNewsId = (new EntUserNews())->where($data)->delete();
            if($EntUserNewsId){
                \app\admin\model\News::where('id',$id)->dec('upvote_count')->update();
                return show(1,'success','取消成功');
            }

            return show(0,'error','取消失败');
        }catch (\Exception $e){
            return show(0,$e->getMessage(),[],'403');
        }

    }

    public function read()
    {
        $id = input('param.id');

        if(empty($id)){
            return show(1,'success','ID不合法',403);
        }

        $data = [
            'user_id' => $this->user['id'],
            'news_id' => $id
        ];

        $isUpvote = EntUserNews::where($data)->find();

        if($isUpvote){
            return show(1,'success',['isUpvote' => 1],200);
        }

        return show(0,'error',['isUpvote' => 0],200);
    }
}