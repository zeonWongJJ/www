package app.vdao.qidu;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.view.ViewPager;
import android.view.KeyEvent;
import android.view.View;
import android.widget.RadioGroup;
import android.widget.Toast;

import com.gzqx.common.base.BaseAppManager;
import com.gzqx.common.base.BaseApplication;
import com.gzqx.common.utils.CommonKey;
import com.gzqx.common.webview.MyCordovaWebView;
import com.gzqx.common.widget.APSTSViewPager;
import com.qidu.chat.activity.ChatMainActivity;
import com.qidu.chat.fragment.sidebar.SidebarMainFragment;

import app.vdao.qidu.R;

import app.vdao.qidu.home.HomeFragment;
import app.vdao.qidu.home.MineFragment;

import java.util.ArrayList;
import java.util.List;


public class MainActivity extends ChatMainActivity implements View.OnClickListener{

    private List<Fragment> fragmentList=new ArrayList<>();
    private List<String> pathList=new ArrayList<>();
    //@BindView(R.id.group)
    RadioGroup mGroup;

    //@BindView(R.id.content)
    APSTSViewPager mPager;

    private FragmentAdapter fragmentAdapter;

    private BroadcastReceiver broadcastReceiver=new BroadcastReceiver() {
        @Override
        public void onReceive(Context context, Intent intent) {
            /*String action=intent.getStringExtra("");
            if(action.equals(CommonKey.KEY_RESET_CURRENT_FRAGMENT)){

            }*/
            if(mPager!=null){
                mPager.setCurrentItem(0);
            }
        }
    };

    @Override
    protected void onDestroy() {
        super.onDestroy();
        unregisterReceiver(broadcastReceiver);

    }

    /*@TargetApi(19)
    public static void transparencyBar(Activity activity) {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            Window window = activity.getWindow();
            window.clearFlags(WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS
                    | WindowManager.LayoutParams.FLAG_TRANSLUCENT_NAVIGATION);
            window.getDecorView().setSystemUiVisibility(View.SYSTEM_UI_FLAG_LAYOUT_FULLSCREEN
                    | View.SYSTEM_UI_FLAG_LAYOUT_HIDE_NAVIGATION
                    | View.SYSTEM_UI_FLAG_LAYOUT_STABLE);
            window.addFlags(WindowManager.LayoutParams.FLAG_DRAWS_SYSTEM_BAR_BACKGROUNDS);
            window.setStatusBarColor(Color.TRANSPARENT);
            window.setNavigationBarColor(Color.TRANSPARENT);
        } else if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT) {
            Window window = activity.getWindow();
            window.setFlags(WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS,
                    WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS);
        }
    }*/

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        BaseAppManager.getInstance().addActivity(this);
        super.onCreate(savedInstanceState);
        initViewsAndEvents(savedInstanceState);
    }

    protected void initViewsAndEvents(Bundle savedInstanceState) {
        mGroup= (RadioGroup) findViewById(R.id.group);
        mPager= (APSTSViewPager) findViewById(R.id.content);
        IntentFilter filter= new IntentFilter(CommonKey.KEY_RESET_CURRENT_FRAGMENT);
        registerReceiver(broadcastReceiver,filter);
        //initStatusBar();
        pathList.add("http://wap.7dugo.com/index");
        pathList.add("http://lyt.zoosnet.net/lr/chatpre.aspx?id=lyt42657310&r=&rf1=http%3A//wap.7dugo&rf2=.com/&p=http%3A//wap.7dugo.com/index&cid=1500010564448573754117&sid=1500010564448573754117");
        pathList.add("http://wap.7dugo.com/classify.html");

        pathList.add("http://wap.7dugo.com/shop.html");
        pathList.add("http://wap.7dugo.com/member.html");
        //fragmentList.add(new HomePageFragment());
        fragmentList.add(new HomeFragment());
        fragmentList.add(new HomeFragment());
        fragmentList.add(new SidebarMainFragment());
        fragmentList.add(new MineFragment());
        /*for(int i=0;i<4;i++){
            fragmentList.add(new HomeFragment());
        }*/
        mPager.setNoFocus(true);
        mGroup.setOnCheckedChangeListener(new CheckedChangeListener());
        mGroup.check(R.id.home);
        fragmentAdapter=new FragmentAdapter(getSupportFragmentManager());
        mPager.setAdapter(fragmentAdapter);
        mPager.addOnPageChangeListener(new PageChangeListener());
        mPager.setOffscreenPageLimit(5);

    }

    @Override
    public void onClick(View v) {

    }

    private class CheckedChangeListener implements RadioGroup.OnCheckedChangeListener {
        @Override
        public void onCheckedChanged(RadioGroup group, int checkedId) {
            switch (checkedId) {
                case R.id.home:
                    mPager.setCurrentItem(0);
                    break;
                case R.id.find:
                    mPager.setCurrentItem(1);
                    break;
                case R.id.classify:
                    mPager.setCurrentItem(2);
                    break;
                case R.id.conversation:
                    mPager.setCurrentItem(3);
                    break;
                case R.id.mine:
                    mPager.setCurrentItem(4);
                    break;
            }
        }
    }

    protected int getContentViewID() {
        return R.layout.activity_main;
    }



    @Override
    public void finish()
    {
        if(getSupportFragmentManager().getFragments().size()>0){
            for(int i=0;i<fragmentList.size();i++){
                try {
                    if(fragmentList.get(i) instanceof HomeFragment){

                        MyCordovaWebView myCordovaWebView=(MyCordovaWebView)fragmentList.get(i).getView().findViewById(R.id.appView);
                        if(myCordovaWebView!=null) {
                            myCordovaWebView.handleDestroy();
                        }
                    }
                } catch (NullPointerException e) {
                    e.printStackTrace();
                }
            }
            fragmentList.clear();
            if(fragmentAdapter!=null){
                fragmentAdapter.notifyDataSetChanged();
            }
            getSupportFragmentManager().getFragments().clear();
        }
        super.finish();
        BaseAppManager.getInstance().removeActivity(this);
    }


    private long exitTime = 0;

    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if(keyCode == KeyEvent.KEYCODE_BACK && event.getAction() == KeyEvent.ACTION_DOWN){
            if((System.currentTimeMillis()-exitTime) > 2000){
                Toast.makeText(this, "再按一次退出程序", Toast.LENGTH_SHORT).show();
                exitTime = System.currentTimeMillis();
            } else {
                BaseApplication.getInstance().exit();
                finish();
            }
            return true;
        }
        return super.onKeyDown(keyCode, event);
    }
    public class FragmentAdapter extends FragmentPagerAdapter {
        public FragmentAdapter(FragmentManager fm) {
            super(fm);
        }
        @Override
        public Fragment getItem(int position) {
            if(position==3||position==4) {
                Bundle bundle = new Bundle();
                bundle.putString("hostname", hostname);
                fragmentList.get(position).setArguments(bundle);
                return fragmentList.get(position);
            }else {
                Bundle bundle = new Bundle();
                bundle.putString("KEY_PATH", pathList.get(position));
                fragmentList.get(position).setArguments(bundle);
                return fragmentList.get(position);
            }
        }

        @Override
        public int getCount() {
            return fragmentList.size();
        }

        /*@Override
        public CharSequence getPageTitle(int position) {
            return mTabs.get(position).title;
        }*/
    }


    private class PageChangeListener implements ViewPager.OnPageChangeListener{

        @Override
        public void onPageScrolled(int position, float positionOffset, int positionOffsetPixels) {

        }

        @Override
        public void onPageSelected(int position) {
            switch (position) {
                case 0:
                    mGroup.check(R.id.home);
                    break;
                case 1:
                    mGroup.check(R.id.find);
                    break;
                case 2:
                    mGroup.check(R.id.classify);
                    break;
                case 3:
                    mGroup.check(R.id.conversation);
                    break;
                case 4:
                    mGroup.check(R.id.mine);
                    break;
            }
        }

        @Override
        public void onPageScrollStateChanged(int state) {

        }
    }

}