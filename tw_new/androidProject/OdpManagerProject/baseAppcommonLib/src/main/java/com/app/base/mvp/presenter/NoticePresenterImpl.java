package com.app.base.mvp.presenter;

import android.text.TextUtils;
import android.util.Log;

import com.app.base.bean.AbsenceBean;
import com.app.base.bean.AnnouncementBean;
import com.app.base.bean.Notice;
import com.app.base.bean.Participant;
import com.app.base.bean.Task;
import com.app.base.bean.UserRealm;
import com.app.base.mvp.contract.NoticeContract;
import com.app.base.netUtil.NoticeHttpUtil;
import com.app.base.utils.GsonUtil;
import com.common.lib.basemvp.presenter.BasePresenter;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * Created by 7du-28 on 2018/6/23.
 */

public class NoticePresenterImpl extends BasePresenter<NoticeContract.View> implements NoticeContract.Presenter{
    private String url;

    public NoticePresenterImpl(String url) {
        this.url = url;
    }

    @Override
    public void loadData(final int pageIndex, HashMap<String,String> hashMap) {
        Disposable disposable= NoticeHttpUtil.getInstance().noticeReceivedOrPublishList(url,hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String data) {
                List<Notice> noticeList=new ArrayList<>();
                if(!TextUtils.isEmpty(data)){
                    try {
                        JSONObject object=new JSONObject(data);
                        String str=object.getString("list");
                        if(str!=null&&!str.equals("null")) {
                            noticeList = GsonUtil.getObjectList(object.getString("list"), Notice.class);
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
                mView.noticeListData(pageIndex,noticeList);
            }

            @Override
            public void onError(Throwable e) {
                mView.showNoticeListFailure(e);
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


    @Override
    public void departmentAndMembers(){
        UserRealm.queryAllUserRealm(new UserRealm.QueryDbCallBack<UserRealm>() {
            @Override
            public void querySuccess(List<UserRealm> items, boolean hasMore) {
                mView.showUserListSuccess(items);
            }
        });

    }

    /*private void getDepartmentAndMember(){
        HashMap<String, String> hashMap=new HashMap<>();
        Disposable disposable= MemberHttpUtil.getInstance().departmentAndMembers(hashMap, new DisposableObserver<List<Participant>>() {
            @Override
            public void onNext(List<Participant> list) {
                mView.showParticipantListSuccess(list);
            }
            @Override
            public void onError(Throwable e) {

            }

            @Override
            public void onComplete() {

            }
        });
        mCompositeSubscription.add(disposable);
    }*/

    @Override
    public void getNoticeDetails(HashMap<String, String> hashMap) {
        Disposable disposable= NoticeHttpUtil.getInstance().getNoticeDetails(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String data) {
                AnnouncementBean announcementBean=null;
                if(!TextUtils.isEmpty(data)&&!data.equals("")){
                    try {
                        JSONObject object=new JSONObject(data);
                        String str=object.getString("list");
                        if(str!=null){
                            announcementBean= GsonUtil.getObject(str,AnnouncementBean.class);
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
                mView.getNoticeDetails(announcementBean);
            }
            @Override
            public void onError(Throwable e) {
                mView.getNoticeDetails(null);
            }
            @Override
            public void onComplete() {
            }
        },String.class);
        mCompositeSubscription.add(disposable);
    }

    @Override
    public void publishNotice(boolean isEdit,HashMap<String, String> hashMap) {
        Disposable disposable= NoticeHttpUtil.getInstance().publishNotice(isEdit,hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String response){
                mView.publishNoticeSuccess();
            }
            @Override
            public void onError(Throwable e) {
                mView.failure();
            }
            @Override
            public void onComplete() {

            }
        },String.class);
        mCompositeSubscription.add(disposable);
    }
}
