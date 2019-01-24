package com.app.base.utils;

import android.text.TextUtils;
import android.widget.EditText;
import android.widget.TextView;

import com.common.lib.utils.ToastUtils;

/**
 * Created by 7du-28 on 2018/6/7.
 */

public class CheckTextUtil {
    private static CheckTextUtil util;
    public static CheckTextUtil getInstance(){
        if(util==null){
            util=new CheckTextUtil();
        }
        return util;
    }


    public void checkText(TextView textView,String tips){
        if(TextUtils.isEmpty(textView.getText().toString().trim())){
            ToastUtils.show(tips);
            return;
        }
    }public void checkText(EditText editText, String tips){
        if(TextUtils.isEmpty(editText.getText().toString().trim())){
            ToastUtils.show(tips);
            return;
        }
    }

}
