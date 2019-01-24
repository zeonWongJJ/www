package app.vdaoadmin.qidu.fragment;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.os.Handler;
import android.support.annotation.Nullable;
import android.support.v4.widget.SwipeRefreshLayout;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.GridView;
import android.widget.ImageView;
import android.widget.ScrollView;
import android.widget.TextView;

import com.app.base.bean.StatisticsBean;
import com.app.base.widget.CircleProgress;
import com.app.base.widget.FullGridView;
import com.base.lv.ListGridUtils;
import com.common.lib.utils.ToastUtils;
import com.mvp.lib.base.BaseFragment;

import java.util.ArrayList;
import java.util.List;

import app.vdaoadmin.qidu.MainActivity;
import app.vdaoadmin.qidu.R;
import app.vdaoadmin.qidu.activity.ListMessageActivity;
import app.vdaoadmin.qidu.activity.MobileShopkeeperActivity;
import app.vdaoadmin.qidu.adapter.MonthGridAdapter;
import app.vdaoadmin.qidu.bean.HomeGridItem;
import app.vdaoadmin.qidu.mvp.contract.HomeContract;
import app.vdaoadmin.qidu.mvp.presenter.HomePresenterImpl;


@SuppressLint("ValidFragment")
public class HomeFragment extends BaseFragment<HomePresenterImpl> implements HomeContract.View,View.OnClickListener{
    private String mTitle;
    private ImageView message;
    private View btn_total_order,btn_total_store,btn_total_user;
    private TextView total_order,total_store,total_user,total_shopkeeper,order_by_day,money_by_day,total_money;

    private View btn_mobile_shop_keeper;
    private MonthGridAdapter adapter;
    private ScrollView scrollview;
    private SwipeRefreshLayout refresh_layout;

    private FullGridView gridView;
    public static HomeFragment getInstance(String title) {
        HomeFragment sf = new HomeFragment();
        sf.mTitle = title;
        return sf;
    }
    private void initData(StatisticsBean statisticsBean){
        total_money.setText(statisticsBean.getSales());
        total_order.setText(statisticsBean.getOrder());
        total_store.setText(statisticsBean.getStoreCount());
        total_user.setText(statisticsBean.getUserCount());
        total_shopkeeper.setText(statisticsBean.getShopkeepersCount());
        order_by_day.setText(statisticsBean.getDaily_order()+"");
        money_by_day.setText(statisticsBean.getDaily_sales()+"");
        List<HomeGridItem> list=new ArrayList<>();
        HomeGridItem itemOrder=new HomeGridItem();
        itemOrder.setItemType(1);
        itemOrder.setLastMonth(statisticsBean.getYue().getAcco()+"");
        itemOrder.setThisMonth(statisticsBean.getYue().getAccott()+"");
        list.add(itemOrder);
        HomeGridItem itemUser=new HomeGridItem();
        itemUser.setItemType(2);
        itemUser.setLastMonth(statisticsBean.getYue().getUser()+"");
        itemUser.setThisMonth(statisticsBean.getYue().getUser_ben()+"");
        list.add(itemUser);
        HomeGridItem itemStore=new HomeGridItem();
        itemStore.setItemType(3);
        itemStore.setLastMonth(statisticsBean.getYue().getStore()+"");
        itemStore.setThisMonth(statisticsBean.getYue().getStor_ben()+"");
        list.add(itemStore);
        HomeGridItem itemShopKeeper=new HomeGridItem();
        itemShopKeeper.setItemType(4);
        itemShopKeeper.setLastMonth(statisticsBean.getYue().getShop()+"");
        itemShopKeeper.setThisMonth(statisticsBean.getYue().getShop_ben()+"");
        list.add(itemShopKeeper);
        if(adapter!=null){
            adapter.refresh(list);
            //ListGridUtils.setGridViewHeightBasedOnChildren(gridView);
            scrollview.smoothScrollTo(0,0);
            scrollview.setFocusable(true);
        }
    }
    @Override
    public void onClick(View v) {
        if(v==message){
            Intent intent=new Intent(getActivity(),ListMessageActivity.class);
            startActivity(intent);
        }else if(v==btn_mobile_shop_keeper){
            Intent intent=new Intent(getActivity(), MobileShopkeeperActivity.class);
            startActivity(intent);

        }else if(v==btn_total_order){
            MainActivity activity= (MainActivity) getActivity();
            activity.fragmentTabChange(2);
        }else if(v==btn_total_store){
            MainActivity activity= (MainActivity) getActivity();
            activity.fragmentTabChange(2);
        }else if(v==btn_total_user){
            MainActivity activity= (MainActivity) getActivity();
            activity.fragmentTabChange(1);
        }
    }

    @Override
    public void initViewsAndEvents(View view, @Nullable Bundle savedInstanceState) {
        refresh_layout=findView(R.id.refresh_layout);
        refresh_layout.setColorSchemeResources(com.app.base.R.color.bg_yellow_color, com.app.base.R.color.bg_yellow_color);
        scrollview=findView(R.id.scrollview);
        TextView header_text=findView(R.id.header_text);
        header_text.setText("V稻");
        total_money=findView(R.id.total_money);
        total_order=findView(R.id.total_order);
        total_store=findView(R.id.total_store);
        total_user=findView(R.id.total_user);
        total_shopkeeper=findView(R.id.total_shopkeeper);
        btn_total_store=findView(R.id.btn_total_store);
        btn_total_user=findView(R.id.btn_total_user);
        btn_total_order=findView(R.id.btn_total_order);
        btn_total_order.setOnClickListener(this);
        btn_total_store.setOnClickListener(this);
        btn_total_user.setOnClickListener(this);
        order_by_day=findView(R.id.order_by_day);
        money_by_day=findView(R.id.money_by_day);
        btn_mobile_shop_keeper=findView(R.id.btn_mobile_shop_keeper);
        btn_mobile_shop_keeper.setOnClickListener(this);
        message=findView(R.id.header_left_btn_img);
        message.setImageDrawable(getActivity().getResources().getDrawable(R.drawable.icon_message));
        message.setOnClickListener(this);

        gridView=findView(R.id.gridView);
        adapter=new MonthGridAdapter(getActivity(),gridView,null);
        gridView.setAdapter(adapter);
        /*pv = (CircleProgress) findView(R.id.progressview1);
        pv.setTextColor(textColor).setCircleBackgroud(CircleColor)
                .setPreProgress(progressColor).setProgress(preColor)
                .setProdressWidth(50).setPaddingscale(0.8f);
        han.sendEmptyMessageDelayed(1, 100);*/
        //mPresenter.loadData();
        refresh_layout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                mPresenter.loadData();
            }
        });
    }

    @Override
    public View initView(LayoutInflater inflater, @Nullable Bundle savedInstanceState) {
        View v = inflater.inflate(R.layout.fragment_home, null);
        return v;
    }

    @Override
    protected HomePresenterImpl initPresenter() {
        return new HomePresenterImpl();
    }

    @Override
    public void getStatisticsDataSuccess(StatisticsBean statisticsBean) {
        if(statisticsBean==null){
            return;
        }
        initData(statisticsBean);
        refresh_layout.setRefreshing(false);
    }



    @Override
    public void getStatisticsDataFailure() {
        refresh_layout.setRefreshing(false);
    }
}