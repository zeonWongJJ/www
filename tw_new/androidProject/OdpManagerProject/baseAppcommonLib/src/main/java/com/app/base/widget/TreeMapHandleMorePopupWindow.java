package com.app.base.widget;

import android.app.Activity;
import android.content.Context;
import android.graphics.drawable.ColorDrawable;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.PopupWindow;

import com.anthony.rvhelper.adapter.MultiItemTypeAdapter;
import com.anthony.rvhelper.divider.DividerItemDecoration;
import com.app.base.R;
import com.app.base.adapter.TypeSelectPopuAdapter;
import com.app.base.bean.Project;
import com.app.base.bean.TypeSelect;

import java.util.List;

/**
 * 添加节点页面 - 操作弹窗
 */

public class TreeMapHandleMorePopupWindow extends PopupWindow {
    private RecyclerView listView;
    private TypeSelectPopuAdapter selectAdapter;
    private View conentView;
    private Activity context;
    public TreeMapHandleMorePopupWindow(Activity context) {
        super(context);
        this.context=context;
        initView();
    }

    private void initView(){
        LayoutInflater inflater = (LayoutInflater) context
                .getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        this.conentView = inflater.inflate(R.layout.layout_tree_map_handle_more_popupwindow, null);
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
        DividerItemDecoration decoration=new DividerItemDecoration(context, LinearLayoutManager.VERTICAL,R.drawable.list_divider_transparent);
        decoration.showLastFootViewDivider(false);
        this.listView.addItemDecoration(decoration);
        //设置适配器
        this.selectAdapter = new TypeSelectPopuAdapter(context);
        this.selectAdapter.setType(1);
        this.listView.setAdapter(selectAdapter);
        selectAdapter.setOnItemClickListener(new MultiItemTypeAdapter.OnItemClickListener() {
            @Override
            public void onItemClick(View view, RecyclerView.ViewHolder holder, Object o, int position) {
                onItemListener.OnItemListener(position,selectAdapter.getDatas().get(position));
            }

            @Override
            public boolean onItemLongClick(View view, RecyclerView.ViewHolder holder, Object o, int position) {
                return false;
            }
        });

    }
    //设置数据
    public void setDataSource(List<TypeSelect> projectList) {
        this.selectAdapter.refreshData(projectList);
        this.selectAdapter.notifyDataSetChanged();
    }
    public void show(View v){
        //https://blog.csdn.net/copy_yuan/article/details/51674237
        //this.showAtLocation(v, Gravity.RIGHT, 0, 0);
        int[] location = new int[2];
        v.getLocationOnScreen(location);
        this.showAtLocation(v, Gravity.NO_GRAVITY, location[0] + v.getWidth(), location[1]);
    }

    public interface OnItemListener {
        public void OnItemListener(int position, TypeSelect project);
    }

    ;
    private OnItemListener onItemListener;
    public void setOnItemMyListener(OnItemListener onItemListener) {
        this.onItemListener = onItemListener;
    }
}
