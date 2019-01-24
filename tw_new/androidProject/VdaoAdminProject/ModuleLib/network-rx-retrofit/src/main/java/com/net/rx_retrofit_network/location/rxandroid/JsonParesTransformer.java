package com.net.rx_retrofit_network.location.rxandroid;


import com.net.rx_retrofit_network.factory.JSONFactory;
import com.net.rx_retrofit_network.location.model.BaseResponse;

import io.reactivex.Observable;
import io.reactivex.ObservableSource;
import io.reactivex.ObservableTransformer;
import io.reactivex.android.schedulers.AndroidSchedulers;
import io.reactivex.functions.Function;
import io.reactivex.schedulers.Schedulers;


public class JsonParesTransformer<T> implements ObservableTransformer<BaseResponse<String>, T> {
    private final Class<T> zClass;

    public JsonParesTransformer(Class<T> zClass) {
        this.zClass = zClass;
    }

    @Override
    public ObservableSource<T> apply(Observable<BaseResponse<String>> upstream) {
        return upstream.compose(new NetWorkTransformer<String>())
                .observeOn(Schedulers.computation())
                .flatMap(new Function<String, ObservableSource<T>>() {
                    @Override
                    public ObservableSource<T> apply(String s) throws Exception {
                        return Observable.just(JSONFactory.fromJson(s, zClass));
                    }
                })
                .observeOn(AndroidSchedulers.mainThread());
    }
}
