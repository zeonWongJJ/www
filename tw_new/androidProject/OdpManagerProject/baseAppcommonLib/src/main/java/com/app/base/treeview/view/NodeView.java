package com.app.base.treeview.view;

import android.annotation.SuppressLint;
import android.content.Context;
import android.graphics.Color;
import android.graphics.drawable.Drawable;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.AttributeSet;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.widget.FrameLayout;
import android.widget.TextView;

import com.app.base.R;
import com.app.base.adapter.JustSimpleAdapter;
import com.app.base.bean.StructureBean;
import com.app.base.bean.User;
import com.app.base.treeview.model.NodeModel;
import com.app.base.widget.ZzHorizontalProgressBar;
import com.common.lib.base.BaseApplication;
import com.common.lib.utils.LogUtils;

import java.util.ArrayList;
import java.util.List;


/**
 * Created by owant on 09/02/2017.
 */

public class NodeView extends FrameLayout {
    //layout_tree_node_item
    public NodeModel<StructureBean> treeNode = null;
    private ZzHorizontalProgressBar pb;
    private TextView title;
    /*private RecyclerView task_list;
    private JustSimpleAdapter adapter;*/
    public NodeView(Context context) {
        this(context, null, 0);
    }

    public NodeView(Context context, AttributeSet attrs) {
        this(context, attrs, 0);
    }

    public NodeView(Context context, AttributeSet attrs, int defStyleAttr) {
        super(context, attrs, defStyleAttr);
        LayoutInflater.from(context).inflate(R.layout.layout_tree_node_item, this,true);
        title=findViewById(R.id.title);
        pb = findViewById(R.id.pb);
        //set progress value
        pb.setProgress(0);
        //set max value
        pb.setMax(100);
        /*task_list=findViewById(R.id.task_list);
        adapter=new JustSimpleAdapter(context);
        task_list.setLayoutManager(new LinearLayoutManager(context));
        task_list.setAdapter(adapter);*/
        //task_list.setNestedScrollingEnabled(false);
        /*setTextColor(Color.WHITE);
        setPadding(12, 10, 12, 10);

        Drawable drawable = context.getResources().getDrawable(R.drawable.node_view_bg);
        setBackgroundDrawable(drawable);*/
    }

    public NodeModel<StructureBean> getTreeNode() {
        return treeNode;
    }

    public void setTreeNode(NodeModel<StructureBean> treeNode) {
        this.treeNode = treeNode;
        setSelected(treeNode.isFocus());
        title.setText(treeNode.getValue().getStructure_name()+"");
        if(treeNode.getValue().getNode_progress()==null){
            pb.setProgressColor(BaseApplication.getInstance().getResources().getColor(R.color.node_progress_color));
            pb.setProgress(0);
        }else {
            pb.setProgressColor(BaseApplication.getInstance().getResources().getColor(R.color.node_progress_bg));
            int progress=Integer.parseInt(treeNode.getValue().getNode_progress());
            pb.setProgress(progress);
        }
        //initRecyclerView();
    }

    /*private void initRecyclerView(){
        List<User> list=new ArrayList<>();
        for(int i=0;i<5;i++){
            User user=new User();
            user.firstname="hlagjndlsfjkdljfsldkjfsldkfjlsdkhgf";
            list.add(user);
        }
        adapter.refreshData(list);
        adapter.notifyDataSetChanged();
    }*/
    /*@Override
    public boolean onInterceptTouchEvent(MotionEvent ev) {
        getParent().requestDisallowInterceptTouchEvent(true);
        return true;
    }*/

    /*@Override
    public boolean dispatchTouchEvent(MotionEvent ev) {
        getParent().requestDisallowInterceptTouchEvent(true);
        return super.dispatchTouchEvent(ev);
    }*/
}