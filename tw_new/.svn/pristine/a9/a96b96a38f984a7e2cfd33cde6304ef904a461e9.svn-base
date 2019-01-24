package com.gzqx.common.httpbase.net;

import android.content.Context;
import android.util.Log;
import android.widget.Toast;

import io.reactivex.Observer;
import io.reactivex.disposables.Disposable;
import io.reactivex.observers.DisposableObserver;


public abstract class BaseDisposableObserver<T> extends DisposableObserver<T> {

    private Context context;
    private boolean isNeedCahe;

    public BaseDisposableObserver(Context context) {
        this.context = context;
    }



    @Override
    public void onError(Throwable e) {

        if(e instanceof ExceptionHandle.ResponseThrowable){
            onError((ExceptionHandle.ResponseThrowable)e);
        } else {
            onError(new ExceptionHandle.ResponseThrowable(e, ExceptionHandle.ERROR.UNKNOWN));
        }
    }


    @Override
    public void onStart() {
        super.onStart();
        if (!NetworkUtil.isNetworkAvailable(context)) {
            Toast.makeText(context, "无网络，读取缓存数据", Toast.LENGTH_SHORT).show();
            onComplete();
        }

    }

    @Override
    public void onComplete() {
        Toast.makeText(context, "http is Complete", Toast.LENGTH_SHORT).show();
    }


    public abstract void onError(ExceptionHandle.ResponseThrowable e);

}
