package com.app.base.widget;

import android.animation.Animator;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.graphics.drawable.ColorDrawable;
import android.os.Handler;
import android.support.v7.widget.DefaultItemAnimator;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.Display;
import android.view.LayoutInflater;
import android.view.View;
import android.view.WindowManager;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.PopupWindow;
import android.widget.SimpleAdapter;

import com.anthony.rvhelper.adapter.MultiItemTypeAdapter;
import com.anthony.rvhelper.divider.DividerItemDecoration;
import com.app.base.R;
import com.app.base.adapter.TopMenuPopAdapter;
import com.app.base.bean.TopMenuItem;
import com.app.base.utils.AnimUtil;
import com.common.lib.adapter.ActionSheetDialogAdapter;
import com.common.lib.bean.ActionItem;
import com.common.lib.utils.ScreenUtils;
import com.common.lib.widget.ActionSheetDialog;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

/**
 * Created by 7du-28 on 2018/3/21.
 */

public class TopMenuPopupWindow{
    /*
    仿微信右上角弹框
    调用
    TopMenuPopupWindow menuPopupWindow=new TopMenuPopupWindow(getActivity());
                menuPopupWindow.showPop(v);*/
    private AnimUtil animUtil;
    private View mMenuView;
    private float bgAlpha = 1f;
    private boolean bright = false;

    private static final long DURATION = 500;
    private static final float START_ALPHA = 0.7f;
    private static final float END_ALPHA = 1f;
    private RecyclerView recyclerView;
    private Activity activity;
    private Display display;
    public TopMenuPopupWindow(Activity context) {
        this.activity=context;
        WindowManager windowManager = (WindowManager) context
                .getSystemService(Context.WINDOW_SERVICE);
        display = windowManager.getDefaultDisplay();
    }
    PopupWindow popupWindow;
    public TopMenuPopupWindow builder() {
        View contentView=LayoutInflater.from(activity).inflate(R.layout.pop_add, null);
        recyclerView=contentView.findViewById(R.id.recyclerview);
        recyclerView.setLayoutManager(new LinearLayoutManager(activity, LinearLayoutManager.VERTICAL, false));
        recyclerView.setOverScrollMode(View.OVER_SCROLL_NEVER);
        popupWindow=new PopupWindow(activity);
        popupWindow.setWidth(RecyclerView.LayoutParams.WRAP_CONTENT);
        popupWindow.setHeight(RecyclerView.LayoutParams.WRAP_CONTENT);
        animUtil = new AnimUtil();
        // 设置布局文件
        popupWindow.setContentView(contentView);
        mMenuView=popupWindow.getContentView();
        // 设置pop透明效果
        popupWindow.setBackgroundDrawable(new ColorDrawable(0x0000));
        // 设置pop出入动画
        popupWindow.setAnimationStyle(R.style.pop_add);
        // 设置pop获取焦点，如果为false点击返回按钮会退出当前Activity，如果pop中有Editor的话，focusable必须要为true
        popupWindow.setFocusable(true);
        // 设置pop可点击，为false点击事件无效，默认为true
        popupWindow.setTouchable(true);
        // 设置点击pop外侧消失，默认为false；在focusable为true时点击外侧始终消失
        popupWindow.setOutsideTouchable(true);
        popupWindow.setOnDismissListener(new PopupWindow.OnDismissListener() {
            @Override
            public void onDismiss() {
                toggleBright();
                if(popupWindow!=null){
                    popupWindow=null;
                }
            }
        });

        return this;
    }

    private List<TopMenuItem> sheetItemList;
    private TopMenuPopAdapter adapter;
    public TopMenuPopupWindow setSheetItems(List<TopMenuItem> itemList) {
        if (itemList != null || itemList.size() > 0) {
            this.sheetItemList = itemList;
        }

        int size = sheetItemList.size();
        adapter = new TopMenuPopAdapter(activity);
        if (size >= 6) {
            LinearLayout.LayoutParams params = (LinearLayout.LayoutParams) recyclerView
                    .getLayoutParams();
            params.height = (display.getHeight() - ScreenUtils.getStatusBarHeight(activity) - ScreenUtils.dp2px(activity, 50)) / 2;
            recyclerView.setLayoutParams(params);
        }
        DividerItemDecoration decoration=new DividerItemDecoration(activity, LinearLayoutManager.VERTICAL,R.drawable.list_divider_one);
        decoration.showLastFootViewDivider(false);
        recyclerView.addItemDecoration(decoration);
        ((DefaultItemAnimator) recyclerView.getItemAnimator()).setSupportsChangeAnimations(false);
        recyclerView.setAdapter(adapter);
        adapter.setOnItemClickListener(new MultiItemTypeAdapter.OnItemClickListener() {
            @Override
            public void onItemClick(View view, RecyclerView.ViewHolder holder, Object o, int position) {
                if (listener != null) {
                    if (popupWindow != null) {
                        new Handler().postDelayed(new Runnable(){
                            public void run(){
                                popupWindow.dismiss();
                            }
                        }, 300);
                    }
                    listener.onItemClick(adapter.getDatas().get(position),position);
                }
            }

            @Override
            public boolean onItemLongClick(View view, RecyclerView.ViewHolder holder, Object o, int position) {
                return false;
            }
        });
        adapter.refreshData(sheetItemList);
        return this;
    }


    public void refreshData(List<TopMenuItem> list){
        sheetItemList.clear();
        sheetItemList.addAll(list);
        adapter.refreshData(sheetItemList);
        adapter.notifyDataSetChanged();
    }

    private OnSheetItemClickListener listener;
    public TopMenuPopupWindow setOnSheetItemClickListener(OnSheetItemClickListener listener) {
        this.listener = listener;
        return this;
    }
    public interface OnSheetItemClickListener {
        void onItemClick(TopMenuItem data, int which);
    }

    /*左上角弹出的时候使用*/
    public void showPopByLeftTop(View view){
        popupWindow.setAnimationStyle(android.R.style.Animation_Dialog);
        popupWindow.setOnDismissListener(new PopupWindow.OnDismissListener() {
            @Override
            public void onDismiss() {
                if(popupWindow!=null){
                    popupWindow=null;
                    backgroundAlpha(1.0f);
                }
            }
        });
        backgroundAlpha(0.6f);
        popupWindow.showAsDropDown(view, 5, 30);
    }
    public void showPop(View view) {
        // 相对于 + 号正下面，同时可以设置偏移量
        popupWindow.showAsDropDown(view, -100, 0);
        // 设置pop关闭监听，用于改变背景透明度
        toggleBright();
    }

    private void toggleBright() {
        // 三个参数分别为：起始值 结束值 时长，那么整个动画回调过来的值就是从0.5f--1f的
        animUtil.setValueAnimator(START_ALPHA, END_ALPHA, DURATION);
        animUtil.addUpdateListener(new AnimUtil.UpdateListener() {
            @Override
            public void progress(float progress) {
                // 此处系统会根据上述三个值，计算每次回调的值是多少，我们根据这个值来改变透明度
                bgAlpha = bright ? progress : (START_ALPHA + END_ALPHA - progress);
                backgroundAlpha(bgAlpha);
            }
        });
        animUtil.addEndListner(new AnimUtil.EndListener() {
            @Override
            public void endUpdate(Animator animator) {
                // 在一次动画结束的时候，翻转状态
                bright = !bright;
            }
        });
        animUtil.startAnimator();
    }
    /**
     * 此方法用于改变背景的透明度，从而达到“变暗”的效果
     */
    private void backgroundAlpha(float bgAlpha) {
        WindowManager.LayoutParams lp = activity.getWindow().getAttributes();
        // 0.0-1.0
        lp.alpha = bgAlpha;
        activity.getWindow().setAttributes(lp);
        // everything behind this window will be dimmed.
        // 此方法用来设置浮动层，防止部分手机变暗无效
        activity.getWindow().addFlags(WindowManager.LayoutParams.FLAG_DIM_BEHIND);
    }
}
