package com.app.base.widget;

import android.app.Activity;
import android.content.Context;
import android.graphics.drawable.ColorDrawable;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.WindowManager;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.AdapterView;
import android.widget.ImageView;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.PopupWindow;


import com.anthony.rvhelper.adapter.MultiItemTypeAdapter;
import com.app.base.R;
import com.app.base.adapter.TypeSelectPopuAdapter;
import com.app.base.bean.TypeSelect;
import com.base.lv.ListGridUtils;
import com.common.lib.global.AppUtils;
import com.common.lib.utils.ScreenUtils;

import java.util.ArrayList;
import java.util.List;

/**
 * 仿QQ空间根据位置弹出PopupWindow显示更多操作效果
 */

public class CustomOperationPopWindow extends PopupWindow {



    private Activity context;
    private View conentView;
    private View backgroundView;
    private Animation anim_backgroundView;
    private RecyclerView listView;
    private TypeSelectPopuAdapter selectAdapter;
    ImageView arrow_up, arrow_down;
    List<TypeSelect> typeSelectlist = new ArrayList<>();
    int[] location = new int[2];
    private OnItemListener onItemListener;

    public interface OnItemListener {
        public void OnItemListener(int position, TypeSelect typeSelect);
    }

    ;

    public void setOnItemMyListener(OnItemListener onItemListener) {
        this.onItemListener = onItemListener;
    }

    public CustomOperationPopWindow(Activity context) {
        this.context = context;
        initView();
    }

    public CustomOperationPopWindow(Activity context, List<TypeSelect> typeSelectlist) {
        this.context = context;
        this.typeSelectlist = typeSelectlist;
        initView();
    }

    private void initView() {
        this.anim_backgroundView = AnimationUtils.loadAnimation(context, R.anim.alpha_show_anim);
        LayoutInflater inflater = (LayoutInflater) context
                .getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        this.conentView = inflater.inflate(R.layout.layout_view_opertation_popupwindow, null);
        // 设置SelectPicPopupWindow的View
        this.setContentView(conentView);
        // 设置SelectPicPopupWindow弹出窗体的宽
        //this.setWidth(ViewGroup.LayoutParams.WRAP_CONTENT);
        this.setWidth(RecyclerView.LayoutParams.WRAP_CONTENT);
        // 设置SelectPicPopupWindow弹出窗体的高
        this.setHeight(RecyclerView.LayoutParams.WRAP_CONTENT);
        // 设置SelectPicPopupWindow弹出窗体可点击
        this.setFocusable(true);
        this.setOutsideTouchable(true);
        // 刷新状态
        this.update();
        // 实例化一个ColorDrawable颜色为半透明
        ColorDrawable dw = new ColorDrawable(0x00000000);
        // 点back键和其他地方使其消失,设置了这个才能触发OnDismisslistener ，设置其他控件变化等操作
        this.setBackgroundDrawable(dw);

        //this.setBackgroundDrawable(null);
        // 设置SelectPicPopupWindow弹出窗体动画效果
        //this.setAnimationStyle(R.style.operation_popwindow_anim_style_up);
        this.listView = (RecyclerView) conentView.findViewById(R.id.lv_list);
        this.listView.setLayoutManager(new LinearLayoutManager(context));
        this.arrow_up = (ImageView) conentView.findViewById(R.id.arrow_up);
        this.arrow_down = (ImageView) conentView.findViewById(R.id.arrow_down);

        //设置适配器
        this.selectAdapter = new TypeSelectPopuAdapter(context);
        this.listView.setAdapter(selectAdapter);
        selectAdapter.refreshData(typeSelectlist);
        selectAdapter.notifyDataSetChanged();
        selectAdapter.setOnItemClickListener(new MultiItemTypeAdapter.OnItemClickListener() {
            @Override
            public void onItemClick(View view, RecyclerView.ViewHolder holder, Object o, int position) {
                if (isShowing()) {
                    dismiss();
                }
                onItemListener.OnItemListener(position, typeSelectlist.get(position));
                dismiss();
            }

            @Override
            public boolean onItemLongClick(View view, RecyclerView.ViewHolder holder, Object o, int position) {
                return false;
            }
        });
        this.setOnDismissListener(new OnDismissListener() {
            @Override
            public void onDismiss() {
                if (backgroundView != null) {
                    backgroundView.setVisibility(View.GONE);
                }
                setBackgroundAlpha(1);
            }
        });
    }
    private OnDismissCallBack dismissCallBack;
    public interface OnDismissCallBack{
        void onDismissCallback();
    }
    public void setOnDismissCallBack(OnDismissCallBack callBack){
        this.dismissCallBack=callBack;
    }
    private void setBackgroundAlpha(float bgAlpha){
        WindowManager.LayoutParams layoutParams = context.getWindow().getAttributes();
        layoutParams.alpha = bgAlpha; //0.0-1.0
        context.getWindow().addFlags(WindowManager.LayoutParams.FLAG_DIM_BEHIND);//多加这一句，问题就解决了！这句的官方文档解释是：让窗口背景后面的任何东西变暗
        context.getWindow().setAttributes(layoutParams);
    }
    //设置数据
    public void setDataSource(List<TypeSelect> typeSelectlist) {
        this.typeSelectlist = typeSelectlist;
        this.selectAdapter.refreshData(this.typeSelectlist);
        this.selectAdapter.notifyDataSetChanged();
    }

    private boolean isNeedShowUp=false;
    /**
     * 没有半透明背景  显示popupWindow
     *
     * @param
     */
    public void showPopupWindow(View v) {
        /*v.getLocationOnScreen(location); //获取控件的位置坐标
        //获取自身的长宽高
        conentView.measure(View.MeasureSpec.UNSPECIFIED, View.MeasureSpec.UNSPECIFIED);
        if (location[1] > AppUtils.getScreenHeight() / 2 + 100) { //MainApplication.SCREEN_H 为屏幕的高度，方法可以自己写
            this.setAnimationStyle(R.style.operation_popwindow_anim_style_up);
            arrow_up.setVisibility(View.GONE);
            arrow_down.setVisibility(View.VISIBLE);
            this.showAtLocation(v,Gravity.NO_GRAVITY, 90, location[1] - conentView.getMeasuredHeight());
            //this.showAtLocation(v, Gravity.NO_GRAVITY, location[0] - v.getWidth(), location[1]);
        } else {
            this.setAnimationStyle(R.style.operation_popwindow_anim_style_down);
            arrow_up.setVisibility(View.VISIBLE);
            arrow_down.setVisibility(View.GONE);
            this.showAsDropDown(v, 90, 0);
        }*/
        int windowPos[] = calculatePopWindowPos(v, conentView);
        int xOff = 25; // 可以自己调整偏移
        windowPos[0] -= xOff;

        if(isNeedShowUp){
            this.setAnimationStyle(R.style.operation_popwindow_anim_style_up);
        }else {
            this.setAnimationStyle(R.style.operation_popwindow_anim_style_down);
        }
        setBackgroundAlpha(0.6f);
        this.showAtLocation(v, Gravity.TOP | Gravity.START, windowPos[0], windowPos[1]);
    }

    /**
     * 携带半透明背景  显示popupWindow
     *
     * @param
     */
    public void showPopupWindow(View v, View backgroundView) {
        this.backgroundView = backgroundView;
        v.getLocationOnScreen(location);  //获取控件的位置坐标
        //获取自身的长宽高
        conentView.measure(View.MeasureSpec.UNSPECIFIED, View.MeasureSpec.UNSPECIFIED);
        backgroundView.setVisibility(View.VISIBLE);
        //对view执行动画
        backgroundView.startAnimation(anim_backgroundView);
        if (location[1] > AppUtils.getScreenHeight() / 2 + 100) {  //若是控件的y轴位置大于屏幕高度的一半，向上弹出
            this.setAnimationStyle(R.style.operation_popwindow_anim_style_up);
            arrow_up.setVisibility(View.GONE);
            arrow_down.setVisibility(View.VISIBLE);
            this.showAtLocation(v, Gravity.NO_GRAVITY, (location[0]), location[1] - conentView.getMeasuredHeight());  //显示指定控件的上方
        } else {
            this.setAnimationStyle(R.style.operation_popwindow_anim_style_down);  //反之向下弹出
            arrow_up.setVisibility(View.VISIBLE);
            arrow_down.setVisibility(View.GONE);
            this.showAsDropDown(v, 0, 0);    //显示指定控件的下方
        }
    }

    /**
     * 计算出来的位置，y方向就在anchorView的上面和下面对齐显示，x方向就是与屏幕右边对齐显示
     * 如果anchorView的位置有变化，就可以适当自己额外加入偏移来修正
     * @param anchorView  呼出window的view
     * @param contentView   window的内容布局
     * @return window显示的左上角的xOff,yOff坐标
     */
    private int[] calculatePopWindowPos(final View anchorView, final View contentView) {
        final int windowPos[] = new int[2];
        final int anchorLoc[] = new int[2];
        // 获取锚点View在屏幕上的左上角坐标位置
        anchorView.getLocationOnScreen(anchorLoc);
        final int anchorHeight = anchorView.getHeight();
        // 获取屏幕的高宽
        final int screenHeight = ScreenUtils.getScreenHeight(anchorView.getContext());
        final int screenWidth = ScreenUtils.getScreenWidth(anchorView.getContext());
        // 测量contentView
        contentView.measure(View.MeasureSpec.UNSPECIFIED, View.MeasureSpec.UNSPECIFIED);
        // 计算contentView的高宽
        final int windowHeight = contentView.getMeasuredHeight();
        final int windowWidth = contentView.getMeasuredWidth();
        // 判断需要向上弹出还是向下弹出显示
        isNeedShowUp = (screenHeight - anchorLoc[1] - anchorHeight < windowHeight);
        if (isNeedShowUp) {
            windowPos[0] = screenWidth - windowWidth;
            windowPos[1] = anchorLoc[1] - windowHeight;
        } else {
            windowPos[0] = screenWidth - windowWidth;
            windowPos[1] = anchorLoc[1] + anchorHeight;
        }
        return windowPos;
    }
    /**
     * 显示popupWindow  根据特殊要求高度显示位置
     *
     * @param
     */
    public void showPopupWindow(View v, View backgroundView, int hight) {
        this.backgroundView = backgroundView;
        v.getLocationOnScreen(location);
        //获取自身的长宽高
        conentView.measure(View.MeasureSpec.UNSPECIFIED, View.MeasureSpec.UNSPECIFIED);
        backgroundView.setVisibility(View.VISIBLE);
        //对view执行动画
        backgroundView.startAnimation(anim_backgroundView);
        if (location[1] > AppUtils.getScreenHeight() / 2 + 100) {
            this.setAnimationStyle(R.style.operation_popwindow_anim_style_up);
            arrow_up.setVisibility(View.GONE);
            arrow_down.setVisibility(View.VISIBLE);
            this.showAtLocation(v, Gravity.NO_GRAVITY, (location[0]), location[1] - conentView.getMeasuredHeight()-hight);
        } else {
            this.setAnimationStyle(R.style.operation_popwindow_anim_style_down);
            arrow_up.setVisibility(View.VISIBLE);
            arrow_down.setVisibility(View.GONE);
            this.showAsDropDown(v, 0, 0);
        }
    }
}
