package app.vdao.qidu.activity;

import android.content.Intent;
import android.os.Handler;
import android.view.MotionEvent;
import android.view.View;
import android.widget.ImageView;

import com.gzqx.common.base.AbsBaseActivity;
import com.gzqx.common.utils.HttpUrl;
import com.jauker.widget.BadgeView;

import app.vdao.qidu.AppApplication;
import app.vdao.qidu.R;
import app.vdao.qidu.common.BounceInterpolator;
import app.vdao.qidu.common.EasingType;
import app.vdao.qidu.widget.PanelView;

/**
 * 含标签
 */

public abstract class BaseMarkActivity extends AbsBaseActivity{
    private PanelView panel;

    private ImageView home,chat,found,shoppingCar,dynamicState,userCenter;
    private View bgLayout;
    private float mPosX,mPosY,mCurPosX,mCurPosY;
    private BadgeView badgeViewChat;


    protected void initMark(){
        bgLayout=findViewById(R.id.bg_color);
        bgLayout.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                switch (event.getAction()) {
                    case MotionEvent.ACTION_DOWN:
                        mPosX = event.getX();
                        mPosY = event.getY();
                        break;
                    case MotionEvent.ACTION_MOVE:
                        mCurPosX = event.getX();
                        mCurPosY = event.getY();
                        break;
                    case MotionEvent.ACTION_UP:
                        if (mCurPosY - mPosY > 0
                                && (Math.abs(mCurPosY - mPosY) > 25)) {
                            //向下滑動

                        } else if (mCurPosY - mPosY < 0
                                && (Math.abs(mCurPosY - mPosY) > 25)) {
                            //向上滑动
                            //collapse();
                            if(panel!=null){
                                if(panel.isOpen()){
                                    panel.setOpen(!panel.isOpen(), false);
                                }
                            }
                        }
                        break;
                }
                return true;
            }
        });
        panel = (PanelView) findViewById(R.id.topPanel);
        panel.setOnPanelListener(panelListener);
        panel.setInterpolator(new BounceInterpolator(EasingType.Type.OUT));
        panel.setOnDownListener(new PanelView.OnDownListener() {
            @Override
            public void onDown() {
                bgLayout.setVisibility(View.VISIBLE);
            }
        });
        chat= (ImageView) findViewById(R.id.chat);
        home= (ImageView) findViewById(R.id.home);
        home.setOnClickListener(listener);
        badgeViewChat = new BadgeView(this);
        badgeViewChat.setTargetView(chat);
        badgeViewChat.setBadgeCount(AppApplication.shoppingCarNum);
        chat.setOnClickListener(listener);
        found= (ImageView) findViewById(R.id.found);
        found.setOnClickListener(listener);
        shoppingCar= (ImageView) findViewById(R.id.shopping_car);
        shoppingCar.setOnClickListener(listener);
        dynamicState= (ImageView) findViewById(R.id.dynamic_state);
        dynamicState.setOnClickListener(listener);
        userCenter= (ImageView) findViewById(R.id.user_center);
        userCenter.setOnClickListener(listener);

       /* new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                Animation shake = AnimationUtils.loadAnimation(getActivity(), R.anim.slight_shake);//加载动画资源文件
                panel.getHandle().startAnimation(shake); //给组件播放动画效果
            }
        },500);*/
    }


    private View.OnClickListener listener=new View.OnClickListener() {
        @Override
        public void onClick(View view) {
            if(panel!=null){
                if(panel.isOpen()){
                    panel.setOpen(!panel.isOpen(), false);
                }
            }
            final int id=view.getId();
            new Handler().postDelayed(new Runnable() {
                @Override
                public void run() {
                    if(id== R.id.home){
                        Intent intent=new Intent(getActivity(),CordovaHomeActivity.class);
                        intent.putExtra(HttpUrl.urlKey, HttpUrl.homeUrl);
                        startActivity(intent);
                    }else if(id== R.id.found){
                        Intent intent=new Intent(getActivity(),CordovaHomeActivity.class);
                        intent.putExtra(HttpUrl.urlKey, HttpUrl.foundUrl);
                        startActivity(intent);
                    }else if(id==R.id.shopping_car){
                        Intent intent=new Intent(getActivity(),CordovaHomeActivity.class);
                        intent.putExtra(HttpUrl.urlKey, HttpUrl.shoppingCarUrl);
                        startActivity(intent);
                    }else if(id== R.id.chat){
                        /*Intent intent = new Intent(getActivity(), ChatMainActivity.class);
                        //intent.putExtra("hostname",hostname);
                        intent.putExtra(ChatMainActivity.EXTRA_FINISH_ON_BACK_PRESS, false);
                        //intent.putExtra("isHomePage",false);
                        intent.setFlags(Intent.FLAG_ACTIVITY_REORDER_TO_FRONT | Intent.FLAG_ACTIVITY_CLEAR_TOP);
                        getActivity().startActivity(intent);*/
                    }else if(id==R.id.dynamic_state){
                        Intent intent=new Intent(getActivity(),CordovaHomeActivity.class);
                        intent.putExtra(HttpUrl.urlKey,HttpUrl.showListUrl);
                        startActivity(intent);
                    }else if(id==R.id.user_center){
                        Intent intent=new Intent(getActivity(),CordovaHomeActivity.class);
                        intent.putExtra(HttpUrl.urlKey,HttpUrl.userCenterUrl);
                        startActivity(intent);
                    }
                }
            },300);

        }
    };

    private PanelView.OnPanelListener panelListener=new PanelView.OnPanelListener() {
        @Override
        public void onPanelClosed(PanelView panel) {
            String panelName = getResources().getResourceEntryName(panel.getId());
            //Log.d("TestPanels", "Panel [" + panelName + "] closed");
            bgLayout.setVisibility(View.GONE);
        }

        @Override
        public void onPanelOpened(PanelView panel) {
            String panelName = getResources().getResourceEntryName(panel.getId());
            //Log.d("TestPanels", "Panel [" + panelName + "] opened");
            bgLayout.setVisibility(View.VISIBLE);
        }
    };

}
