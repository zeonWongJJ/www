package com.app.base.mvp.presenter;

import android.text.TextUtils;

import com.app.base.bean.Comment;
import com.app.base.bean.PlanComment;
import com.app.base.mvp.contract.CommentListContract;
import com.app.base.netUtil.PublishCommentHttpUtil;
import com.app.base.utils.GsonUtil;
import com.app.base.utils.HttpUrl;
import com.common.lib.basemvp.presenter.BasePresenter;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * 评论列表
 */

public class CommentListPresenterImpl extends BasePresenter<CommentListContract.View> implements CommentListContract.Presenter{

    @Override
    public void loadData(final int pageIndex,int pageSize,String task_or_plan_id,String department) {
        HashMap<String,String> hashMap=new HashMap<>();
        /*String url="";
        if(taskOrPlanType.equals("task_record")){
            url= HttpUrl.api_task_comment_list;
            hashMap.put("task_id",task_or_plan_id);
        }else if(taskOrPlanType.equals("plan_record")){
            url= HttpUrl.api_plan_comment_list;
            hashMap.put("plan_id",task_or_plan_id);
        }*/
        String url= HttpUrl.api_task_comment_list;
        hashMap.put("task_id",task_or_plan_id);
        if(!TextUtils.isEmpty(department)){
            hashMap.put("department",department);
        }
        hashMap.put("offset",pageIndex+"");
        hashMap.put("rows",pageSize+"");
        Disposable disposable= PublishCommentHttpUtil.getInstance().taskCommentList(url,hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String data) {
                List<Comment> commentList=new ArrayList<>();
                if(!TextUtils.isEmpty(data)&&!data.equals("")){
                    commentList= GsonUtil.getObjectList(data,Comment.class);
                }
                mView.commentListData(pageIndex,commentList);
            }

            @Override
            public void onError(Throwable e) {
                mView.onFailure(e);
            }
            @Override
            public void onComplete() {

            }
        },String.class);
        mCompositeSubscription.add(disposable);

    }

    @Override
    public void loadPlanData(final int pageIndex, int pageSize, String task_or_plan_id, String department) {
        HashMap<String,String> hashMap=new HashMap<>();
        String url= HttpUrl.api_plan_comment_list;
        hashMap.put("plan_id",task_or_plan_id);
        if(!TextUtils.isEmpty(department)){
            hashMap.put("department",department);
        }
        hashMap.put("offset",pageIndex+"");
        hashMap.put("rows",pageSize+"");
        Disposable disposable= PublishCommentHttpUtil.getInstance().planCommentList(url,hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String data) {
                List<PlanComment> commentList=new ArrayList<>();
                if(!TextUtils.isEmpty(data)&&!data.equals("")){
                    commentList= GsonUtil.getObjectList(data,PlanComment.class);
                }
                mView.commentPlanListData(pageIndex,commentList);
            }

            @Override
            public void onError(Throwable e) {
                mView.onFailure(e);
            }
            @Override
            public void onComplete() {

            }
        },String.class);
        mCompositeSubscription.add(disposable);
    }

    @Override
    public void loadActionRecordList(final int pageIndex,int pageSize,String task_id,String department,String actionType) {
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("task_id",task_id);
        hashMap.put("offset",pageIndex+"");
        hashMap.put("rows",pageSize+"");
        hashMap.put("task_record_type",actionType);
        if(!TextUtils.isEmpty(department)){
            hashMap.put("department",department);
        }
        //Log.i("aaaaaaaaaaaa",hashMap.toString());
        Disposable disposable= PublishCommentHttpUtil.getInstance().actionCommentList(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String data) {
                List<Comment> comments=new ArrayList<>();
                if(!TextUtils.isEmpty(data)&&!data.equals("")){
                    comments=GsonUtil.getObjectList(data,Comment.class);
                }
                mView.commentListData(pageIndex,comments);
            }

            @Override
            public void onError(Throwable e) {
                mView.onFailure(e);
            }
            @Override
            public void onComplete() {

            }
        },String.class);
        mCompositeSubscription.add(disposable);
    }

    @Override
    public void onCreate() {
    }

    @Override
    public void loadData() {

    }
}
