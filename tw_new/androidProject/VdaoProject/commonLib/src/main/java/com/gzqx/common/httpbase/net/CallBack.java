package com.gzqx.common.httpbase.net;


public abstract class CallBack {
    public void onStart(){}

    public void onCompleted(){}

    abstract public void onError(Throwable e);

    public void onProgress(long fileSizeDownloaded,long fileSize){}

    abstract public void onSuccess(String path, String name, long fileSize);
}
