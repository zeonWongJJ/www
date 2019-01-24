package com.common.lib.base;

import android.annotation.TargetApi;
import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.text.TextUtils;
import android.util.Log;
import android.view.Window;
import android.view.WindowManager;


public abstract class AbsBaseFragment extends Fragment {


    @TargetApi(19)
    protected void setTranslucentStatus(boolean on) {
        Window win = getActivity().getWindow();
        WindowManager.LayoutParams winParams = win.getAttributes();
        final int bits = WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS;
        if (on) {
            winParams.flags |= bits;
        } else {
            winParams.flags &= ~bits;
        }
        win.setAttributes(winParams);
    }


    /**
     * Hide content and show the progress bar
     */

    protected ProgressDialog mProgressDialog;

    public ProgressDialog showProgressDialog(String title, String message) {
        return showProgressDialog(title, message, -1,true);
    }
    public ProgressDialog showProgressDialog(String message) {
        return showProgressDialog("",message);
    }
    public ProgressDialog showProgressDialog(String title, String message, int theme, boolean isCanceledOnTouchOutside) {
        if (mProgressDialog == null) {
            if (theme > 0)
                mProgressDialog = new ProgressDialog(getActivity(), theme);
            else
                mProgressDialog = new ProgressDialog(getActivity());
            mProgressDialog.setProgressStyle(ProgressDialog.STYLE_SPINNER);
            mProgressDialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
            mProgressDialog.setCanceledOnTouchOutside(isCanceledOnTouchOutside);// 不能取消
            mProgressDialog.setCancelable(isCanceledOnTouchOutside);
            mProgressDialog.setIndeterminate(true);// 设置进度条是否不明确
        }

        if (!TextUtils.isEmpty(title))
            mProgressDialog.setTitle(title);
        mProgressDialog.setMessage(message);
        mProgressDialog.show();
        return mProgressDialog;
    }

    public void dismissProgressDialog() {
        if (mProgressDialog != null) {
            mProgressDialog.dismiss();
        }
    }



    public ProgressDialog progressDialog;

    public ProgressDialog showProgressDialog() {
        return showProgressDialog("","正在加载中");
    }
}

