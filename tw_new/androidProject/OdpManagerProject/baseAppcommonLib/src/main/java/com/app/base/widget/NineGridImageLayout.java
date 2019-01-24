package com.app.base.widget;

import android.app.Activity;
import android.content.Context;
import android.graphics.drawable.Drawable;
import android.support.annotation.Nullable;
import android.util.AttributeSet;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.DataSource;
import com.bumptech.glide.load.engine.GlideException;
import com.bumptech.glide.request.RequestListener;
import com.bumptech.glide.request.RequestOptions;
import com.bumptech.glide.request.target.Target;
import com.luck.picture.lib.PictureSelector;
import com.luck.picture.lib.entity.LocalMedia;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by 7du-28 on 2018/1/8.
 */

public class NineGridImageLayout extends NineGridLayout {
    private Activity activity;
    protected static final int MAX_W_H_RATIO = 3;

    private RequestOptions options=new RequestOptions();

    public NineGridImageLayout(Context context) {
        super(context);
    }

    public void setActivityContext(Activity activity){
        this.activity=activity;
    }

    public NineGridImageLayout(Context context, AttributeSet attrs) {
        super(context, attrs);
    }

    @Override
    protected boolean displayOneImage(final RatioImageView imageView, String url, final int parentWidth) {

        Glide.with(mContext).load(url).listener(new RequestListener<Drawable>() {
            @Override
            public boolean onLoadFailed(@Nullable GlideException e, Object model, Target<Drawable> target, boolean isFirstResource) {
                return false;
            }

            @Override
            public boolean onResourceReady(Drawable resource, Object model, Target<Drawable> target, DataSource dataSource, boolean isFirstResource) {

                int w = resource.getIntrinsicWidth();
                int h = resource.getIntrinsicHeight();

                int newW;
                int newH;
                if (h > w * MAX_W_H_RATIO) {//h:w = 5:3
                    newW = parentWidth / 2;
                    newH = newW * 5 / 3;
                } else if (h < w) {//h:w = 2:3
                    newW = parentWidth * 2 / 3;
                    newH = newW * 2 / 3;
                } else {//newH:h = newW :w
                    newW = parentWidth / 2;
                    newH = h * newW / w;
                }
                setOneImageLayoutParams(imageView, newW, newH);
                return false;
            }
        }).into(imageView);
        return false;
    }

    @Override
    protected void displayImage(RatioImageView imageView, String url) {
        options.override(150);
        Glide.with(mContext).load(url).apply(options).into(imageView);
    }

    @Override
    protected void onClickImage(int position, String url, List<String> urlList) {

        if(activity!=null&&urlList.size()>0){
            List<LocalMedia> selectList=new ArrayList<>();
            for(String path:urlList){
                LocalMedia media=new LocalMedia();
                media.setPath(path);
                selectList.add(media);
            }
            PictureSelector.create(activity).externalPicturePreview(position, selectList);
        }
    }
}
