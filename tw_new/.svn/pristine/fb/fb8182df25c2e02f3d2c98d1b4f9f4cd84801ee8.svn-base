package app.odp.qidu.adapter;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.support.v7.widget.GridLayoutManager;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.utils.GlideRoundTransform;
import com.app.base.utils.HttpUrl;
import com.bumptech.glide.Glide;
import com.bumptech.glide.TransitionOptions;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.bumptech.glide.request.RequestOptions;
import com.luck.picture.lib.PictureSelector;
import com.luck.picture.lib.entity.LocalMedia;
import com.luck.picture.lib.tools.ScreenUtils;

import java.util.ArrayList;
import java.util.List;

import app.odp.qidu.R;

//计划适配器
public class PlanShowImgAdapter extends CommonAdapter<LocalMedia> {
    private int itemWidth;
    private Activity activity;
    public PlanShowImgAdapter(Activity context) {
        super(context, R.layout.layout_plan_img_item);
        this.activity=context;
        //100是布局里面除去recyclerView的剩余屏幕宽度
        this.itemWidth=(ScreenUtils.getScreenWidth(mContext)-ScreenUtils.dip2px(mContext,100)- ScreenUtils.dip2px(mContext,10)*3)/4;

    }


    @Override
    protected void convert(ViewHolder holder, final LocalMedia data, int position) {
        ImageView img=holder.getView(R.id.img);
        LinearLayout.LayoutParams params= (LinearLayout.LayoutParams) img.getLayoutParams();
        params.height=itemWidth;
        params.width=itemWidth;
        img.setLayoutParams(params);
        /*holder.getConvertView().getLayoutParams().width=itemHeight;
        holder.getConvertView().getLayoutParams().height=itemHeight;*/
        RequestOptions options = new RequestOptions()
                .centerCrop()
                .transform(new GlideRoundTransform(mContext))
                .diskCacheStrategy(DiskCacheStrategy.ALL);
        if(!TextUtils.isEmpty(data.getImageUrl())){
            Glide.with(mContext)
                    .load(HttpUrl.HOST+data.getImageUrl())
                    .apply(options)
                    .into(img);
        }
        holder.getConvertView().setOnClickListener(v -> {
            if(getDatas().size()>0){
                PictureSelector.create(activity).externalPicturePreview(position,getDatas());
            }
        });
    }
}
