package com.gzqx.common.base;

import android.annotation.TargetApi;
import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.pm.ActivityInfo;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.os.Build;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.support.v4.content.ContextCompat;
import android.support.v4.content.PermissionChecker;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.FrameLayout;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.gzqx.com.gzqx.org.common.R;
import com.gzqx.common.sysutil.StatusBarUtil;
import com.gzqx.common.utils.KeyBoardListener;
import com.luck.picture.lib.tools.LightStatusBarUtils;
import com.luck.picture.lib.tools.ToolbarUtil;

import org.reactivestreams.Subscriber;

import java.lang.reflect.Field;
import java.lang.reflect.Method;
import java.util.ArrayList;
import java.util.List;

import butterknife.ButterKnife;
import butterknife.Unbinder;
import io.reactivex.Observable;
import io.reactivex.Observer;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.disposables.CompositeDisposable;
import io.reactivex.disposables.Disposable;
import io.reactivex.functions.Function;
import io.reactivex.internal.disposables.ListCompositeDisposable;
import io.reactivex.schedulers.Schedulers;
import retrofit2.Call;

import static android.R.attr.targetSdkVersion;


/**
 * Created by Anthony on 2016/4/24.
 * Class Note:
 * 1 all activities implement from this class
 * <p>
 * todo add Umeng analysis
 */
public abstract class AbsBaseActivity extends FragmentActivity {

    protected static String TAG_LOG = null;// Log tag
    protected Context mContext = null;//context
    private List<Call> calls;

    private Unbinder mUnbinder;
    private ListCompositeDisposable listCompositeDisposable = new ListCompositeDisposable();


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        //StatusBarUtil.StatusBarLightMode(getActivity());
        /*getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
                WindowManager.LayoutParams.FLAG_FULLSCREEN);*/
        //LightStatusBarUtils.setLightStatusBar(this, true);//更改状态栏字体和图标颜色
        super.onCreate(savedInstanceState);

        init(savedInstanceState);
        //KeyBoardListener.getInstance(this).init();//设置全屏的时候input标签弹出键盘布局上移
    }


    private void init(Bundle savedInstanceState) {
        mContext = this;
        TAG_LOG = this.getClass().getSimpleName();
        //save activities stack
        BaseAppManager.getInstance().addActivity(this);
        setContentView(getContentViewID());
        setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);//强制竖屏
        //
        //ToolbarUtil.setColorNoTranslucent(this,ContextCompat.getColor(this, R.color.blue));
        //bind this after setContentView
        mUnbinder = ButterKnife.bind(this);
        initViewsAndEvents(savedInstanceState);
    }


    protected TextView headTitle,headLocation;
    protected View headBack;
    protected void initTitleView(){
        headBack=findViewById(R.id.header_left_btn_img);
        headTitle= (TextView) findViewById(R.id.header_text);
        headBack.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });

    }

    protected Activity getActivity(){
        return this;
    }

    @Override
    protected void onDestroy() {
        // 退出时销毁定位

        callCancel();
        clear();
        super.onDestroy();
        if (mUnbinder != null) {
            mUnbinder.unbind();
            mUnbinder = null;
        }
    }

    @Override
    public void finish() {
        super.finish();
        BaseAppManager.getInstance().removeActivity(this);
    }

    protected abstract void initViewsAndEvents(Bundle savedInstanceState);
    /**
     * bind layout resource file
     */
    protected abstract int getContentViewID();


    /**
     * Hide content and show the progress bar
     */
    public ProgressDialog progressDialog;

    public ProgressDialog showProgressDialog() {
        progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("加载中");
        progressDialog.show();
        return progressDialog;
    }

    public ProgressDialog showProgressDialog(CharSequence message) {
        progressDialog = new ProgressDialog(this);
        progressDialog.setMessage(message);
        progressDialog.show();
        return progressDialog;
    }

    public void dismissProgressDialog() {
        if (progressDialog != null && progressDialog.isShowing()) {
            // progressDialog.hide();会导致android.view.WindowLeaked
            progressDialog.dismiss();
        }
    }

    public void startActivity(Class<? extends Activity> tarActivity, Bundle options) {
        Intent intent = new Intent(this, tarActivity);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.JELLY_BEAN) {
            startActivity(intent, options);
        } else {
            startActivity(intent);
        }
    }

    public void startActivity(Class<? extends Activity> tarActivity) {
        Intent intent = new Intent(this, tarActivity);
        startActivity(intent);
    }
    public void addCalls(Call call) {
        if (calls == null) {
            calls = new ArrayList<>();
        }
        calls.add(call);
    }

    private void callCancel() {
        if (calls != null && calls.size() > 0) {
            for (Call call : calls) {
                if (!call.isCanceled())
                    call.cancel();
            }
            calls.clear();
        }
    }
    protected void addDisposable(Disposable disposable) {
        if (disposable != null && !disposable.isDisposed()) {
            listCompositeDisposable.add(disposable);
        }
    }

    protected void reDisposable(Disposable disposable) {
        if (disposable != null) {
            listCompositeDisposable.remove(disposable);
        }
    }

    protected void clear() {
        if (!listCompositeDisposable.isDisposed()) {
            listCompositeDisposable.clear();
        }
    }

    /**
     * 针对6.0动态请求权限问题
     * 判断是否允许此权限
     *
     * @param permission
     * @return
     */
    protected boolean hasPermission(String permission) {
        boolean result = true;
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
            if (targetSdkVersion >= Build.VERSION_CODES.M) {
                result = mContext.checkSelfPermission(permission)
                        == PackageManager.PERMISSION_GRANTED;
            } else {
                result = PermissionChecker.checkSelfPermission(mContext, permission)
                        == PermissionChecker.PERMISSION_GRANTED;
            }
        }
        return result;
    }


    /*public void reload() {
        Intent intent = getIntent();
        overridePendingTransition(0, 0);
        intent.addFlags(Intent.FLAG_ACTIVITY_NO_ANIMATION);
        finish();
        overridePendingTransition(0, 0);
        startActivity(intent);
    }*/


}
