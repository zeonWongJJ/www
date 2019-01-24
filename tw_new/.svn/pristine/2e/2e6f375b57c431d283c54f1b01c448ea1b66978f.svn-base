package app.odp.qidu.fragment;

import android.graphics.Color;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import com.anthony.rvhelper.divider.DividerItemDecoration;
import com.app.base.base.AbsListFragment;
import com.app.base.bean.AnnouncementBean;
import com.app.base.bean.Notice;
import com.app.base.bean.UserRealm;
import com.app.base.mvp.contract.NoticeContract;
import com.app.base.mvp.presenter.NoticePresenterImpl;
import com.app.base.netUtil.NoticeHttpUtil;
import com.app.base.utils.HttpUrl;
import com.common.lib.utils.ToastUtils;
import com.common.lib.widget.AppDialog;
import com.common.lib.widget.StatusViewLayout;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.adapter.AnnouncementNoticeAdapter;
import io.reactivex.observers.DisposableObserver;

/**
 * 会话
 */

public class AnnouncementNoticeFragment extends AbsListFragment<NoticePresenterImpl> implements NoticeContract.View{
    private AnnouncementNoticeAdapter adapter;
    private String tabType;
    private String member_id;
    public static AnnouncementNoticeFragment getInstance(String tabType) {
        AnnouncementNoticeFragment sf = new AnnouncementNoticeFragment();
        sf.tabType = tabType;
        return sf;
    }

    @Override
    public void loadData(int pageIndex) {
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("offset",pageIndex+"");//pageIndex*pageSize
        hashMap.put("rows",pageSize+"");
        mPresenter.loadData(pageIndex,hashMap);
    }

    @Override
    public void onResume() {
        super.onResume();
        refreshData();
    }

    @Override
    public View initView(LayoutInflater inflater, @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.lib_fragment_base_recyclerview, null);
        return view;
    }

    @Override
    public void initViewsAndEvents(View view, @Nullable Bundle savedInstanceState) {

        StatusViewLayout mStatusViewLayout=view.findViewById(R.id.status_view_layout);
        //mStatusViewLayout.resetEmptyView();
        SwipeRefreshLayout mPtr=view.findViewById(R.id.refresh_layout);
        RecyclerView mRecyclerView=view.findViewById(R.id.recyclerview);
        adapter = new AnnouncementNoticeAdapter(this,tabType,listener);
        DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_default);
        decoration.showLastFootViewDivider(false);
        mRecyclerView.addItemDecoration(decoration);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));
        initPagingListWithoutHeader(mRecyclerView, adapter, mPtr, mStatusViewLayout);
        /*List<Notice> list=new ArrayList<>();
        for(int i=0;i<10;i++){
            Notice notice=new Notice();
            notice.setMsgType(i);
            notice.setTitle("老实干活来得及分公司了大家分工");
            list.add(notice);
        }
        adapter.refreshData(list);*/
    }

    @Override
    protected NoticePresenterImpl initPresenter() {
        String url="";
        if(tabType.equals("0")){
            url= HttpUrl.api_bulletin_received;
        }else if(tabType.equals("1")){
            url= HttpUrl.api_bulletin_initiated;
        }
        return new NoticePresenterImpl(url);
    }

    @Override
    public void noticeListData(int pageIndex, List<Notice> list) {
        onDataSuccessReceived(pageIndex,list);
    }

    @Override
    public void showNoticeListFailure(Throwable throwable) {
        showError(throwable);
    }

    @Override
    public void showUserListSuccess(List<UserRealm> list) {

    }

    @Override
    public void publishNoticeSuccess() {

    }

    @Override
    public void failure() {

    }

    @Override
    public void getNoticeDetails(AnnouncementBean announcementBean) {

    }

    //删除我发起的通知
    private void deleteMineNotice(int position,Notice data){
        showProgressDialog();
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("id",data.getId());
        NoticeHttpUtil.getInstance().deleteMineNotice(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String s) {
                dismissProgressDialog();
                adapter.getDatas().remove(position);
                mLoadMoreWrapper.notifyDataSetChanged();
                ToastUtils.show(s);
            }

            @Override
            public void onError(Throwable e) {
                dismissProgressDialog();
                ToastUtils.show(e.getMessage());
            }

            @Override
            public void onComplete() {

            }
        },String.class);
    }


    private View.OnClickListener listener=new View.OnClickListener() {
        @Override
        public void onClick(View v) {
            int position= (int) v.getTag();
            Notice data=adapter.getDatas().get(position);
            new AppDialog.Builder(mContext).setTitle("提示").setMsg("确定删除该通知?").setOk("确定").setCancel("取消").setClickListener(new AppDialog.OnClickListener() {
                @Override
                public void onOkClick() {
                    deleteMineNotice(position, data);
                }
                @Override
                public void onCancelClick() {}
                @Override
                public void onDismiss() {}
            }).create();

        }
    };
}