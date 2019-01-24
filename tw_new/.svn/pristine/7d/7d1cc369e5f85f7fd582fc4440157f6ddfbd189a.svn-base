package common.widget;

import android.content.Context;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.util.AttributeSet;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.AdapterView;
import android.widget.GridView;
import android.widget.RelativeLayout;


import java.util.ArrayList;
import java.util.List;

import chat.rocket.android.widget.ChatFunctionFragment;
import chat.rocket.android.widget.R;
import chat.rocket.android.widget.message.MessageExtraActionItemPresenter;
import common.adapter.AppsAdapter;
import common.data.AppBean;

public class SimpleAppsGridView extends RelativeLayout {

    protected View view;
    /*private Fragment functionFragment;
    private Fragment currentFragment;*/

    public SimpleAppsGridView(Fragment fragment,AdapterView.OnItemClickListener itemClickListener) {
        this(fragment.getActivity(), null);
        //this.currentFragment=fragment;
        this.itemClickListener=itemClickListener;
        init();
    }

    public SimpleAppsGridView(Context context, AttributeSet attrs) {
        super(context, attrs);
        LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        view = inflater.inflate(R.layout.view_apps, this);
    }

    /*public void refreshDataChange(List<MessageExtraActionItemPresenter> actionItems){
        FragmentManager manager =currentFragment.getActivity().getSupportFragmentManager();
        FragmentTransaction transaction = manager.beginTransaction();
        functionFragment=ChatFunctionFragment.create(actionItems);
        functionFragment.setTargetFragment(currentFragment, 1);
        transaction.replace(R.id.id_content, functionFragment);
        transaction.commit();
    }*/

    protected void init(){
        GridView gv_apps = (GridView) view.findViewById(R.id.gv_apps);
        ArrayList<AppBean> mAppBeanList = new ArrayList<>();
        mAppBeanList.add(new AppBean(1,R.drawable.qq_skin_aio_panel_image_press, "相册"));
        mAppBeanList.add(new AppBean(2,R.drawable.qq_skin_aio_panel_camera_press, "拍照"));
        mAppBeanList.add(new AppBean(3,R.drawable.icon_video, "视频"));
        mAppBeanList.add(new AppBean(4,R.drawable.qq_skin_aio_panel_hongbao_press, "红包"));
        mAppBeanList.add(new AppBean(5,R.drawable.icon_collection, "收藏"));
        mAppBeanList.add(new AppBean(6,R.drawable.icon_file_choose, "文件"));
        mAppBeanList.add(new AppBean(7,R.drawable.icon_loaction, "位置"));
        AppsAdapter adapter = new AppsAdapter(getContext(), mAppBeanList);
        gv_apps.setOnItemClickListener(itemClickListener);
        gv_apps.setAdapter(adapter);

    }
    private AdapterView.OnItemClickListener itemClickListener;

}
