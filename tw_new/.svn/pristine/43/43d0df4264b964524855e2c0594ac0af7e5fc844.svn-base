package app.odp.qidu.adapter;

import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;

import java.util.List;

/**
 * Created by 7du-28 on 2018/6/2.
 */

public class MyPagerAdapter<T extends Fragment> extends FragmentPagerAdapter {
    private List<T> mFragments;
    public MyPagerAdapter(FragmentManager fm,List<T> mFragments) {
        super(fm);
        this.mFragments=mFragments;
    }

    @Override
    public int getCount() {
        return mFragments.size();
    }

    @Override
    public CharSequence getPageTitle(int position) {
        return null;
    }

    @Override
    public Fragment getItem(int position) {
        return mFragments.get(position);
    }
}
