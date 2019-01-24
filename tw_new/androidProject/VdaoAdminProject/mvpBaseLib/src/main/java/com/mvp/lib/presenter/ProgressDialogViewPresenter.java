package com.mvp.lib.presenter;

import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.DialogInterface;

import com.mvp.lib.view.IBaseView;
import com.mvp.lib.view.IProgressDialogView;

import io.reactivex.Observable;

/**
 * @author jlanglang  2016/12/17 10:59
 * @版本 2.0
 */

public abstract class ProgressDialogViewPresenter<T extends IBaseView> extends BasePresenter<T>
        implements IProgressDialogView {
    private ProgressDialog loading;

    /**
     * 使用默认的Dialog
     */
    public Dialog getLoadingDialog() {
        if (loading == null) {
            loading = new ProgressDialog(mView.getContext());
            loading.setOnCancelListener(new DialogInterface.OnCancelListener() {
                @Override
                public void onCancel(DialogInterface dialog) {
                    mCompositeSubscription.clear();
                }
            });
        }
        return loading;
    }

    /**
     * 自定义dialog
     *
     * @param progressDialog
     */
    public void setLoadingDialog(ProgressDialog progressDialog) {
        this.loading = progressDialog;
        loading.setOnCancelListener(new DialogInterface.OnCancelListener() {
            @Override
            public void onCancel(DialogInterface dialog) {
                mCompositeSubscription.clear();
            }
        });
    }

    /**
     * 对Observable进行修改,使其加载数据时弹出ProgressDialog
     */
    /*public <R> Observable<R> loadingSubscribe(Observable<R> observable) {
        return observable.doOnSubscribe(new Action() {
            @Override
            public void call() {
                getLoadingDialog().show();
            }
        }).doOnNext(new Action1<R>() {
            @Override
            public void call(R r) {
                getLoadingDialog().dismiss();
            }
        }).doOnCompleted(new Action0() {
            @Override
            public void call() {
                getLoadingDialog().dismiss();
            }
        }).doOnError(new Action1<Throwable>() {
            @Override
            public void call(Throwable throwable) {
                getLoadingDialog().dismiss();
            }
        });
    }*/
}
