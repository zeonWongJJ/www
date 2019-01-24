package app.vdao.qidu;

import android.os.Bundle;
import android.os.Handler;
import android.support.v4.widget.SwipeRefreshLayout;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import com.anthony.rvhelper.adapter.MultiItemTypeAdapter;
import com.anthony.rvhelper.divider.DividerItemDecoration;
import com.anthony.rvhelper.wrapper.HeaderAndFooterWrapper;
import com.anthony.rvhelper.wrapper.LoadMoreWrapper;
import com.gzqx.common.base.AbsBaseActivity;
import app.vdao.qidu.R;

import app.vdao.qidu.adapter.ChatAdapterForRv;
import app.vdao.qidu.adapter.JustSimpleAdapter;

import java.util.ArrayList;
import java.util.List;

import app.vdao.qidu.bean.Topic;

import butterknife.BindView;

public class ListActivity extends AbsBaseActivity {
    @BindView(R.id.recycleView)
    RecyclerView recycleView;
    private JustSimpleAdapter mJustTitleAdapter;
    private List<Topic> strs=new ArrayList<>();


    @BindView(R.id.recycleView1)
    protected RecyclerView mRecyclerView;
    @BindView(R.id.swipe_container)
    protected SwipeRefreshLayout mPtr;
    protected ChatAdapterForRv mRecyclerAdapter;
    private LoadMoreWrapper mLoadMoreWrapper;
    private HeaderAndFooterWrapper mHeaderAndFooterWrapper;
    @Override
    protected void initViewsAndEvents(Bundle savedInstanceState) {
        mJustTitleAdapter = new JustSimpleAdapter(mContext);
        recycleView.addItemDecoration(new DividerItemDecoration(mContext, LinearLayoutManager.VERTICAL,R.drawable.list_divider_default));
        recycleView.setLayoutManager(new LinearLayoutManager(mContext));
        recycleView.setAdapter(mJustTitleAdapter);

        for(int i=0;i<5;i++){
            strs.add(new Topic("item"+i, "1014",false));
        }
        /*strs.add(new Topic("todo图文添加以及上传", "1014",false));
        strs.add(new Topic("todo栏目订阅排序", "",true));
        strs.add(new Topic("todo LeadCloud登录注册", "",false));
        strs.add(new Topic("todo ShareSDK分享", "",true));
        strs.add(new Topic("todo 即时通讯", "",false));
        strs.add(new Topic("todo 直播", "",true));*/
        mJustTitleAdapter.refreshData(strs);
        mJustTitleAdapter.notifyDataSetChanged();


        mRecyclerView.setLayoutManager(new LinearLayoutManager(this));
        //mRecyclerView.addItemDecoration(new DividerItemDecoration(mContext, LinearLayoutManager.VERTICAL,R.drawable.list_divider_default));

        mRecyclerAdapter = new ChatAdapterForRv(this);
        mHeaderAndFooterWrapper = new HeaderAndFooterWrapper(mRecyclerAdapter);

        TextView t1 = new TextView(this);
        t1.setText("Header 1");
        TextView t2 = new TextView(this);
        t2.setText("Header 2");
        mHeaderAndFooterWrapper.addHeaderView(t1);
        mHeaderAndFooterWrapper.addHeaderView(t2);
        TextView t3 = new TextView(this);
        t3.setText("FootView Text");
        mHeaderAndFooterWrapper.addFootView(t3);
        DividerItemDecoration decoration=new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL,R.drawable.list_divider_default);
        decoration.setFootViewCount(mHeaderAndFooterWrapper.getFootersCount()+1);//此处的getFootersCount不包括加载更多的那个footview
        decoration.setHeaderViewCount(mHeaderAndFooterWrapper.getHeadersCount());
        mRecyclerView.addItemDecoration(decoration);
        mLoadMoreWrapper = new LoadMoreWrapper(this,mHeaderAndFooterWrapper);

        //mLoadMoreWrapper.setLoadMoreView(LayoutInflater.from(this).inflate(R.layout.layout_default_loading, mRecyclerView, false));
        mLoadMoreWrapper.setOnLoadMoreListener(new LoadMoreWrapper.OnLoadMoreListener()
        {
            @Override
            public void onRetry() {
                //重试处理
            }

            @Override
            public void onLoadMore() {
                //加载更多
                new Handler().postDelayed(new Runnable()
                {
                    @Override
                    public void run()
                    {
                        mRecyclerAdapter.appendData(strs);
                        mLoadMoreWrapper.notifyDataSetChanged();
                        mLoadMoreWrapper.showLoadError();
                        //注意：使用 LoadMoreWrapper onLoadMoreRequested时候，必需使用代理的mLoadMoreWrapper.notifyDataSetChanged();，不能使用mRecyclerAdapter.notifyDataSetChanged();
                    }
                }, 3000);
            }

            /*@Override
            public void onLoadMoreRequested()
            {
                Log.i("aaa","onLoadMoreRequested");

            }*/
        });
        mRecyclerView.setAdapter(mLoadMoreWrapper);
        mRecyclerAdapter.setOnItemClickListener(new MultiItemTypeAdapter.OnItemClickListener()
        {
            @Override
            public void onItemClick(View view, RecyclerView.ViewHolder holder, Object o, int position) {
                Toast.makeText(ListActivity.this, "Click:" + position , Toast.LENGTH_SHORT).show();
            }

            @Override
            public boolean onItemLongClick(View view, RecyclerView.ViewHolder holder, Object o, int position) {
                Toast.makeText(ListActivity.this, "LongClick:" + position , Toast.LENGTH_SHORT).show();
                return false;
            }

        });
        //设置刷新时动画的颜色，可以设置4个
        mPtr.setColorSchemeResources(android.R.color.holo_blue_light, android.R.color.holo_red_light, android.R.color.holo_orange_light, android.R.color.holo_green_light);
        mPtr.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
              @Override
              public void onRefresh() {
                 //tv.setText("正在刷新");
                    new Handler().postDelayed(new Runnable() {
                            @Override
                     public void run() {
                         mRecyclerAdapter.refreshData(strs);
                          mLoadMoreWrapper.notifyDataSetChanged();
                         mPtr.setRefreshing(false);
                     }}, 6000);           }
         });
    }

    @Override
    protected int getContentViewID() {
        return R.layout.activity_list;
    }
}
