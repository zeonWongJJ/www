package app.vdaoadmin.qidu.activity;

import android.annotation.SuppressLint;
import android.os.Build;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.view.ViewPager;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.inputmethod.EditorInfo;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.app.base.utils.IntentParams;
import com.common.lib.base.AbsBaseActivity;
import com.common.lib.utils.ScreenUtils;
import com.common.lib.widget.ClearEditText;
import com.flyco.tablayout.SlidingTabLayout;
import com.flyco.tablayout.listener.OnTabSelectListener;
import com.mvp.lib.base.BaseActivity;
import com.mvp.lib.presenter.BasePresenter;
import com.mvp.lib.view.IBaseActivityView;

import java.util.ArrayList;

import app.vdaoadmin.qidu.R;
import app.vdaoadmin.qidu.fragment.MobileShopkeeperFragment;

/**
 * 移动店主
 */

public class MobileShopkeeperActivity extends AbsBaseActivity implements OnTabSelectListener {

    private ArrayList<MobileShopkeeperFragment> mFragments = new ArrayList<>();
    private String[] mTitles =null;
    private ViewPager vp;
    private MyPagerAdapter mAdapter;
    private ClearEditText searchKey;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_mobile_shop_keeper);
        ImageView status_view= (ImageView) findViewById(R.id.status_view);
        View status_view_layout=findViewById(R.id.status_bar_layout);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT) {
            setTranslucentStatus(true);
            LinearLayout.LayoutParams params= (LinearLayout.LayoutParams) status_view.getLayoutParams();
            params.height= ScreenUtils.getStatusBarHeight(this);
            //params.setMargins(0, ScreenUtils.getStatusBarHeight(this), 0, 0);
            status_view.setLayoutParams(params);
            status_view_layout.setVisibility(View.VISIBLE);
        }
        mTitles = new String[]{"全部", "已通过", "待处理", "已拒绝", "已搁置"};
        for (String title : mTitles) {
            mFragments.add(MobileShopkeeperFragment.getInstance(title));
        }
        View back=findViewById(R.id.back);
        back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
        vp=findViewById(R.id.vp);
        mAdapter = new MyPagerAdapter(getSupportFragmentManager());
        vp.setAdapter(mAdapter);
        SlidingTabLayout tabLayout = findViewById(R.id.sliding_tab_layout);
        tabLayout.setViewPager(vp, mTitles);
        vp.setCurrentItem(0);

        searchKey=findViewById(R.id.search_key);
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
                    MobileShopkeeperFragment a=mFragments.get(vp.getCurrentItem());
                    a.searchShopkeeper(keyWord);
                }
            }
        });
        searchKey.setOnEditorActionListener(new TextView.OnEditorActionListener() {
            @Override
            public boolean onEditorAction(TextView v, int actionId, KeyEvent event) {
                if (actionId == EditorInfo.IME_ACTION_SEARCH) {
                    String keyWord = v.getText().toString();
                    MobileShopkeeperFragment a= mFragments.get(vp.getCurrentItem());
                    a.searchShopkeeper(keyWord);
                    return true;
                }
                return false;
            }
        });
        /*vp.addOnPageChangeListener(new ViewPager.OnPageChangeListener() {
            @Override
            public void onPageScrolled(int position, float positionOffset, int positionOffsetPixels) {

            }

            @Override
            public void onPageSelected(int position) {
                searchKey.setText("");
            }

            @Override
            public void onPageScrollStateChanged(int state) {

            }
        });*/
    }


    @Override
    public void onTabSelect(int position) {
        //searchKey.setText("");
    }

    @Override
    public void onTabReselect(int position) {

    }

    private class MyPagerAdapter extends FragmentPagerAdapter {
        public MyPagerAdapter(FragmentManager fm) {
            super(fm);
        }

        @Override
        public int getCount() {
            return mFragments.size();
        }

        @Override
        public CharSequence getPageTitle(int position) {
            return mTitles[position];
        }

        @Override
        public Fragment getItem(int position) {
            return mFragments.get(position);
        }
    }
}
