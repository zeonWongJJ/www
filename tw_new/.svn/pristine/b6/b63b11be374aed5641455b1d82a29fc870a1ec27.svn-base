package app.vdaoadmin.qidu.fragment;

import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.app.base.bean.AdminBean;
import com.app.base.utils.HttpUrl;
import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.cache.InternalCacheDiskCacheFactory;
import com.common.lib.base.AbsBaseFragment;
import com.common.lib.utils.DataCleanManager;
import com.common.lib.utils.ToastUtils;

import java.io.File;

import app.vdaoadmin.qidu.LauncherActivity;
import app.vdaoadmin.qidu.R;
import app.vdaoadmin.qidu.activity.AboutUsActivity;
import app.vdaoadmin.qidu.activity.LoginActivity;

/**
 * 设置
 */

public class SettingFragment extends AbsBaseFragment implements View.OnClickListener{
    private View login_out;
    private View mView,toggle,btn_about_us,btn_clear_cache;
    private String mTitle;
    private TextView cache_show;
    public static SettingFragment getInstance(String title) {
        SettingFragment sf = new SettingFragment();
        sf.mTitle = title;
        return sf;
    }
    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        mView=inflater.inflate(R.layout.fragment_setting,container,false);
        return mView;
    }

    private boolean isOn=false;
    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        View back=mView.findViewById(R.id.header_left_btn_img);
        back.setVisibility(View.GONE);
        TextView titleCenter=mView.findViewById(R.id.header_text);
        titleCenter.setText("设置");
        btn_clear_cache=mView.findViewById(R.id.btn_clear_cache);
        btn_clear_cache.setOnClickListener(this);
        login_out=mView.findViewById(R.id.login_out);
        login_out.setOnClickListener(this);
        toggle=mView.findViewById(R.id.toggle);
        btn_about_us=mView.findViewById(R.id.btn_about_us);
        btn_about_us.setOnClickListener(this);
        toggle.setOnClickListener(this);
        cache_show=mView.findViewById(R.id.cache_show);
        initCacheSize();

    }

    @Override
    public void onClick(View v) {
        if(login_out==v){
            AdminBean.deleteAdminBean();
            Intent intent = new Intent(getActivity(), LoginActivity.class);
            intent.setFlags(Intent.FLAG_ACTIVITY_REORDER_TO_FRONT | Intent.FLAG_ACTIVITY_CLEAR_TOP);
            startActivity(intent);
            getActivity().finish();
        }else if(toggle==v){
            if(!isOn){
                isOn=true;
                toggle.setBackground(getActivity().getResources().getDrawable(R.drawable.icon_toggle_on));
            }else {
                isOn=false;
                toggle.setBackground(getActivity().getResources().getDrawable(R.drawable.icon_toggle_off));
            }
            ToastUtils.show("该功能暂未开发");
        }else if(btn_about_us==v){
            Intent intent=new Intent(getActivity(),AboutUsActivity.class);
            getActivity().startActivity(intent);
        }else if(btn_clear_cache==v){
            clearCache();
        }
    }

    private void clearCache(){
        new Thread(new Runnable() {
            @Override
            public void run() {
                Glide.get(getActivity()).clearDiskCache();
                DataCleanManager.cleanExternalCache(getActivity());
                getActivity().runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        initCacheSize();
                        ToastUtils.show("已经清除缓存了");
                    }
                });
            }
        }).start();
    }

    private void initCacheSize(){
        try {
            String cacheSize=DataCleanManager.getCacheSize(new File(getActivity().getCacheDir() + "/"+ InternalCacheDiskCacheFactory.DEFAULT_DISK_CACHE_DIR));
            cache_show.setText(cacheSize);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
