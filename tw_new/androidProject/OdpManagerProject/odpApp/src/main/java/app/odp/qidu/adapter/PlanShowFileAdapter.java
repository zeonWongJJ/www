package app.odp.qidu.adapter;

import android.content.Context;
import android.text.TextUtils;
import android.view.View;
import android.widget.ImageView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.utils.HttpUrl;
import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.bumptech.glide.request.RequestOptions;
import com.common.lib.global.AppUtils;
import com.luck.picture.lib.tools.ScreenUtils;

import app.odp.qidu.R;
import choose.lm.com.fileselector.model.FileInfo;

//计划适配器
public class PlanShowFileAdapter extends CommonAdapter<FileInfo> {
    public PlanShowFileAdapter(Context context) {
        super(context, R.layout.layout_plan_file_item);
        this.mContext=context;
    }


    @Override
    protected void convert(ViewHolder holder, final FileInfo data, int position) {
        String url=data.getFileUrl();
        if(data.getFile_name()==null){
            String filename;
            if (url != null &&!"".equals(url)) {
                filename = url.substring(url.lastIndexOf("/") + 1);
                holder.setText(R.id.file_name,filename);
            }
        }else {
            holder.setText(R.id.file_name,data.getFile_name());
        }
        holder.getConvertView().setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(!TextUtils.isEmpty(url)){
                    AppUtils.openBrowser(mContext, HttpUrl.HOST+url);
                }
            }
        });
    }
}
