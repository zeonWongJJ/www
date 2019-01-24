package choose.lm.com.fileselector.activitys;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.os.Environment;
import android.os.Parcelable;
import android.support.design.widget.TabLayout;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.view.ViewPager;
import android.util.Log;
import android.util.TypedValue;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import java.io.File;
import java.io.IOError;
import java.util.ArrayList;
import java.util.List;

import choose.lm.com.fileselector.R;
import choose.lm.com.fileselector.base.BaseFileActivity;
import choose.lm.com.fileselector.fragments.FileFragment;
import choose.lm.com.fileselector.fragments.OtherFragment;
import choose.lm.com.fileselector.fragments.PhotoFragment;
import choose.lm.com.fileselector.fragments.VideoFragment;
import choose.lm.com.fileselector.model.FileInfo;
import choose.lm.com.fileselector.utils.FileUtil;
import choose.lm.com.fileselector.utils.LoadFiles;

public class ChooseFileActivity extends BaseFileActivity{
    public static String FILELISTDATA = "file_data_list";


    private List<FileInfo> mSelectFiles = new ArrayList<>();
    private List<Fragment> mFragmentList = new ArrayList<>();
    private List<String> title = new ArrayList<>();
    private MyPagerAdapter adapter;
    private VideoFragment videoFragment;
    private PhotoFragment photoFragment;
    private FileFragment fileFragment;
    private OtherFragment otherFragment;
    private TextView ctbTitle;
    private ViewPager vpChooseFile;
    private TabLayout tabLayout;
    private TextView idChooseSize,tvSend;
    private View ly_back;
    /**
     * 是否允许多选
     */
    private static final String EXTRA_IS_MULTI_SELECT = "EXTRA_IS_MULTI_SELECT";
    public boolean mIsMultiselect = false;
    private int mCurPosition = 0;

    @Override
    public int getLayoutId() {
        return R.layout.lib_activity_choose_file;
    }

    /**
     * 选择文件的intent
     *
     * @param context       Context
     * @param isMultiselect 是否允许多选
     * @return
     */
    public static Intent newIntent(Context context, boolean isMultiselect) {
        Intent intent = new Intent(context, ChooseFileActivity.class);
        intent.putExtra(EXTRA_IS_MULTI_SELECT, isMultiselect);
        return intent;

    }

    String ACTION_MEDIA_SCANNER_SCAN_DIR = "android.intent.action.MEDIA_SCANNER_SCAN_DIR";

    @Override
    protected void initView(Bundle savedInstanceState) {
        mIsMultiselect = getIntent().getBooleanExtra(EXTRA_IS_MULTI_SELECT, false);
        title.add("影音");
        title.add("图片");
        title.add("文档");
        title.add("其他");
        videoFragment = new VideoFragment();
        photoFragment = new PhotoFragment();
        fileFragment = new FileFragment();
        otherFragment = new OtherFragment();
        mFragmentList.add(videoFragment);
        mFragmentList.add(photoFragment);
        mFragmentList.add(fileFragment);
        mFragmentList.add(otherFragment);

        /*
        Intent scanIntent = new Intent(ACTION_MEDIA_SCANNER_SCAN_DIR);
        scanIntent.setData(Uri.parse("file://" + Environment.getExternalStorageDirectory()));
        sendBroadcast(scanIntent);*/
        //刷新文件
        // sendBroadcast(new Intent(Intent.ACTION_MEDIA_SCANNER_SCAN_FILE, Uri.parse("file://" + Environment.getExternalStorageDirectory())));
        //  sendBroadcast(new Intent(Intent.ACTION_MEDIA_SCANNER_SCAN_FILE, Uri.fromFile(file)));
        ly_back=findViewById(R.id.ly_back);
        ly_back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
        ctbTitle=findViewById(R.id.tv_Title);
        vpChooseFile=findViewById(R.id.vp_choose_file);
        tabLayout=findViewById(R.id.tab_layout);
        idChooseSize=findViewById(R.id.id_choose_size);
        tvSend=findViewById(R.id.tv_send);
        if (mIsMultiselect) {//多选
            tvSend.setText("发送(0)");
        } else {
            tvSend.setText("发送");
        }
        ctbTitle.setText("选择文件");
        ctbTitle.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
        tvSend.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                setResult(RESULT_OK, new Intent().putParcelableArrayListExtra(FILELISTDATA, (ArrayList<? extends Parcelable>) mSelectFiles));
                finish();
            }
        });
        adapter = new MyPagerAdapter(getSupportFragmentManager());
        vpChooseFile.setAdapter(adapter);
        final int pageMargin = (int) TypedValue.applyDimension(TypedValue.COMPLEX_UNIT_DIP, 4, getResources()
                .getDisplayMetrics());
        vpChooseFile.setPageMargin(pageMargin);

        tabLayout.setupWithViewPager(vpChooseFile);
        vpChooseFile.setOffscreenPageLimit(4);
        vpChooseFile.setCurrentItem(0);
        tabLayout.setOnTabSelectedListener(new TabLayout.OnTabSelectedListener() {
            @Override
            public void onTabSelected(TabLayout.Tab tab) {
                mCurPosition = tab.getPosition();
            }

            @Override
            public void onTabUnselected(TabLayout.Tab tab) {

            }

            @Override
            public void onTabReselected(TabLayout.Tab tab) {

            }
        });


        new Thread(){
            @Override
            public void run() {
                super.run();
                try {
                    int qq = findFile(Environment.getExternalStorageDirectory().getAbsolutePath() + "/Tencent/QQfile_recv");
                    int weixin_img = findFile(Environment.getExternalStorageDirectory().getAbsolutePath() + "/Tencent/MicroMsg/Download");
                    int weixin_file = findFile(Environment.getExternalStorageDirectory().getAbsolutePath() + "/Tencent/MicroMsg/WeiXin");
                    if (qq+weixin_img+weixin_file>0) {//扫描qq和微信的文件
                        runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                updateData();
                            }
                        });
                    }
                } catch (IOError e) {
                    Log.e("fileName", "出错了");
                    e.printStackTrace();
                }
            }
        }.start();
    }


    private void updateData()
    {
        videoFragment.loadData();
        photoFragment.loadData();
        fileFragment.loadData();
        otherFragment.loadData();
    }

    private int findFile(String PathName) {

        String fileName[] = (new File(PathName)).list();
        if(fileName == null)
        {
            return 0;
        }
        File fileTemp;

        for (int j = 0; j < fileName.length; j++) {

            fileTemp = new File(PathName + '/' + fileName[j]);
            Log.e("fileName", fileName[j]);
            if (fileTemp.isFile()) {
                LoadFiles.insertFile(getContentResolver(),fileTemp);
            } else if (fileTemp.isDirectory()) {
                findFile(PathName + '/' + fileName[j]);
            }
        }
        return 1;
    }

    public void addFile(FileInfo fileInfo) {
        mSelectFiles.add(fileInfo);
        refershView();
    }

    //单选默认  清楚其他页面的状态和数据
    public void clearFile() {
        mSelectFiles.clear();
        switch (mCurPosition) {
            case 0:
              photoFragment.clearState();
              fileFragment.clearState();
               otherFragment.clearState();
                break;
            case 1:
                videoFragment.clearState();
              fileFragment.clearState();
               otherFragment.clearState();
                break;
            case 2:
                videoFragment.clearState();
               photoFragment.clearState();
               otherFragment.clearState();
                break;
            case 3:
                videoFragment.clearState();
                photoFragment.clearState();
               fileFragment.clearState();
                break;
        }


    }

    public void removeFile(int id) {
        for (int i = 0; i < mSelectFiles.size(); i++) {
            if (id == mSelectFiles.get(i).getId()) {
                mSelectFiles.remove(i);
            }
        }
        refershView();
    }

    private void refershView() {
        int count = 0;
        long size = 0;
        for (int i = 0; i < mSelectFiles.size(); i++) {
            size = size + mSelectFiles.get(i).getFile_size();
            count++;
        }
        idChooseSize.setText("已选" + FileUtil.bytes2kb(size));
        if (count > 0) {
            tvSend.setSelected(true);
            tvSend.setTextColor(getResources().getColor(R.color.colorFFFFFF));
        } else {
            tvSend.setSelected(false);
            tvSend.setTextColor(getResources().getColor(R.color.colorC9C9C9));
        }
        if (mIsMultiselect) {//多选
            tvSend.setText("发送(" + count + ")");
        } else {
            tvSend.setText("发送");
        }

    }



    class MyPagerAdapter extends FragmentPagerAdapter {

        public MyPagerAdapter(FragmentManager fm) {
            super(fm);
        }

        @Override
        public CharSequence getPageTitle(int position) {
            return title.get(position);
        }

        @Override
        public int getCount() {
            return title.size();
        }

        @Override
        public Fragment getItem(int position) {
            return mFragmentList.get(position);
        }

        @Override
        public Object instantiateItem(ViewGroup container, int position) {
            Object obj = super.instantiateItem(container, position);
            return obj;
        }

        @Override
        public void destroyItem(ViewGroup container, int position, Object object) {
            super.destroyItem(container, position, object);
        }
    }
}
