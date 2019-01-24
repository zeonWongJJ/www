package app.vdaoadmin.qidu.fragment;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.text.Editable;
import android.text.TextUtils;
import android.text.TextWatcher;
import android.util.Log;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.inputmethod.EditorInfo;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.MultiItemTypeAdapter;
import com.anthony.rvhelper.divider.DividerItemDecoration;
import com.app.base.base.AbsListFragment;
import com.app.base.bean.User;
import com.common.lib.widget.ClearEditText;
import com.common.lib.widget.StatusViewLayout;
import com.mvp.lib.presenter.BasePresenter;
import com.mvp.lib.view.IBaseFragmentView;

import java.util.ArrayList;
import java.util.List;

import app.vdaoadmin.qidu.R;
import app.vdaoadmin.qidu.adapter.ManagerUserListAdapter;
import app.vdaoadmin.qidu.bean.Topic;
import app.vdaoadmin.qidu.mvp.contract.UserContract;
import app.vdaoadmin.qidu.mvp.presenter.UserPresenterImpl;

/**
 * 用户管理
 */

public class ManageUserFragment extends AbsListFragment<UserPresenterImpl> implements UserContract.View{
    protected RecyclerView mRecyclerView;
    protected SwipeRefreshLayout mPtr;
    private String mTitle;
    protected StatusViewLayout mStatusViewLayout;
    private ClearEditText searchKey;
    private String keywords="";

    private MultiItemTypeAdapter adapter;

    public static ManageUserFragment getInstance(String title) {
        ManageUserFragment sf = new ManageUserFragment();
        sf.mTitle = title;
        return sf;
    }
    /*@TargetApi(19)
    private void setTranslucentStatus(boolean on) {
        Window win = getActivity().getWindow();
        WindowManager.LayoutParams winParams = win.getAttributes();
        final int bits = WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS;
        if (on) {
            winParams.flags |= bits;
        } else {
            winParams.flags &= ~bits;
        }
        win.setAttributes(winParams);
    }*/

    @Override
    public void loadData(int pageIndex) {
        mPresenter.loadData(pageIndex,keywords);
    }

    @Override
    public View initView(LayoutInflater inflater, @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_manage_user_list, null);
        return view;
    }

    @Override
    public void initViewsAndEvents(View view, @Nullable Bundle savedInstanceState) {
        searchKey=findView(R.id.search_key);
        searchKey.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence s, int i, int i1, int i2) {

            }

            @Override
            public void afterTextChanged(Editable editable) {
                String keyWord = editable.toString().trim();
                synchronized (getActivity()) {
                    if(mPresenter!=null){
                        keywords=keyWord;
                        mPresenter.loadData(getInitPageIndex(),keywords);
                    }
                }
                /*if(mPresenter!=null){
                    mPresenter.loadData(getInitPageIndex(),keyWord);
                }*/
            }
        });
        searchKey.setOnEditorActionListener(new TextView.OnEditorActionListener() {
            @Override
            public boolean onEditorAction(TextView v, int actionId, KeyEvent event) {
                if (actionId == EditorInfo.IME_ACTION_SEARCH) {
                    String keyWord = v.getText().toString();
                    /*if(TextUtils.isEmpty(keyWord)){
                        return true;
                    }*/
                    keywords=keyWord;
                    mPresenter.loadData(getInitPageIndex(),keywords);
                    return true;
                }
                return false;
            }
        });
        adapter = new ManagerUserListAdapter(mContext);
        mStatusViewLayout=findView(R.id.status_view_layout);
        mPtr=findView(R.id.refresh_layout);
        mRecyclerView=findView(R.id.recyclerview);
        DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_manager_user);
        decoration.showLastFootViewDivider(false);
        mRecyclerView.addItemDecoration(decoration);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));

        initPagingList(mRecyclerView, adapter, mPtr, mStatusViewLayout);
        View divide = getActivity().getLayoutInflater().inflate(R.layout.layout_recyclerview_divider,null);
        headerAndFooterWrapper.addHeaderView(divide);

        refreshData();
    }

    @Override
    protected UserPresenterImpl initPresenter() {
        return new UserPresenterImpl();
    }

    @Override
    public void showUserList(int pageIndex, List<User> list) {
        onDataSuccessReceived(pageIndex,list);
        if(pageIndex==getInitPageIndex()&&list.size()>0){
            mRecyclerView.scrollToPosition(0);
        }
    }

    @Override
    public void showUserListFailure() {

    }
}