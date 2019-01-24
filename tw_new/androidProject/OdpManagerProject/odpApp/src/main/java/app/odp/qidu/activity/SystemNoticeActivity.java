package app.odp.qidu.activity;

import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.TextUtils;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.MultiItemTypeAdapter;
import com.anthony.rvhelper.divider.DividerItemDecoration;
import com.app.base.base.AbsListActivity;
import com.app.base.bean.AbsenceBean;
import com.app.base.bean.Notice;
import com.app.base.bean.SystemNotice;
import com.app.base.netUtil.NoticeHttpUtil;
import com.app.base.utils.GsonUtil;
import com.common.lib.utils.StatusBarUtil;
import com.common.lib.widget.StatusViewLayout;
import com.luck.picture.lib.immersive.LightStatusBarUtils;
import com.common.lib.basemvp.presenter.BasePresenter;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import app.odp.qidu.R;
import app.odp.qidu.adapter.NoticeListAdapter;
import app.odp.qidu.adapter.SystemNoticeListAdapter;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;

/**
 * 系统通知
 */

public class SystemNoticeActivity extends AbsListActivity<BasePresenter>{
    protected RecyclerView mRecyclerView;
    protected SwipeRefreshLayout mPtr;
    protected StatusViewLayout mStatusViewLayout;
    private MultiItemTypeAdapter adapter;

    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        StatusBarUtil.setStatusBarColor(getActivity(),R.color.white);
        LightStatusBarUtils.setLightStatusBar(getActivity(),true);
        View layout_parent=findViewById(R.id.layout_parent);
        layout_parent.setBackgroundColor(getResources().getColor(R.color.white));
        TextView titleCenter= (TextView) findViewById(R.id.title_center_text);
        titleCenter.setTextColor(getActivity().getResources().getColor(R.color.black));
        titleCenter.setText("系统通知");
        ImageView back= (ImageView) findViewById(R.id.title_left_image);
        back.setImageResource(R.drawable.icon_back_black);
        back.setOnClickListener(v -> {
            finish();
        });
        mStatusViewLayout=findView(R.id.status_view_layout);
        //mStatusViewLayout.resetEmptyView();
        mPtr=findView(R.id.refresh_layout);
        mRecyclerView=findView(R.id.recyclerview);
        adapter = new SystemNoticeListAdapter(this);
        DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_default);
        decoration.showLastFootViewDivider(false);
        mRecyclerView.addItemDecoration(decoration);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));

        initPagingList(mRecyclerView, adapter, mPtr, mStatusViewLayout);
        refreshData();
    }

    @NonNull
    @Override
    protected View initView(@NonNull LayoutInflater inflater, Bundle savedInstanceState) {
        View view=inflater.inflate(R.layout.activity_title_recyclerview_common,null);
        return view;
    }

    @Override
    protected BasePresenter initPresenter() {
        return new BasePresenter() {
            @Override
            public void onCreate() {

            }

            @Override
            public void loadData() {

            }
        };
    }

    @Override
    public void loadData(int pageIndex) {
        HashMap<String,String> hashMap=new HashMap<>();
        hashMap.put("offset",pageIndex+"");//pageIndex*pageSize
        hashMap.put("rows",pageSize+"");
        Disposable disposable= NoticeHttpUtil.getInstance().systemNoticeList(hashMap, new DisposableObserver<String>() {
            @Override
            public void onNext(String data) {
                List<SystemNotice> noticeList=new ArrayList<>();
                if(!TextUtils.isEmpty(data)){
                    try {
                        JSONObject object=new JSONObject(data);
                        String str=object.getString("list");
                        if(str!=null) {
                            noticeList = GsonUtil.getObjectList(object.getString("list"), SystemNotice.class);
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
                onDataSuccessReceived(pageIndex,noticeList);
            }

            @Override
            public void onError(Throwable e) {
                mStatusViewLayout.showError();
            }

            @Override
            public void onComplete() {

            }
        },String.class);
        mPresenter.getCompositeSubscription().add(disposable);
    }
}
