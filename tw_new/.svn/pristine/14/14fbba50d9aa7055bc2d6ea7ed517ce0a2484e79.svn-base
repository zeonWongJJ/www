package com.app.base.rxandroid;

import com.app.base.bean.BaseResponse;
import com.common.lib.utils.APIException;
import com.common.lib.utils.ExceptionHandle;

import io.reactivex.Observable;
import io.reactivex.ObservableSource;
import io.reactivex.ObservableTransformer;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.functions.Function;
import io.reactivex.schedulers.Schedulers;


public class FullResponseTransformer<T> implements ObservableTransformer<BaseResponse<T>, T> {

    private static class HttpResponseFunc<T> implements Function<Throwable, Observable<T>> {
        @Override
        public Observable<T> apply(Throwable throwable) throws ExceptionHandle.ResponseThrowable {
            return Observable.error(ExceptionHandle.handleException(throwable));
        }
    }
    private class HandleFuc<T> implements Function<BaseResponse<T>, T> {

        @Override
        public T apply(BaseResponse<T> tBaseResponse) throws APIException {
            if (tBaseResponse.getError()==BaseResponse.STATUS_SUCCESS) {
                return tBaseResponse.getData();
            }
            throw new APIException(tBaseResponse.getError(), tBaseResponse.getMsg());
        }
    }
    @Override
    public ObservableSource<T> apply(Observable<BaseResponse<T>> upstream) {
        return upstream
                .subscribeOn(Schedulers.io())
                .observeOn(AndroidSchedulers.mainThread())
                .unsubscribeOn(Schedulers.io())
                .map(new HandleFuc<T>()).onErrorResumeNext(new HttpResponseFunc<T>());
    }

}