package app.odp.qidu.adapter;

import android.app.Activity;
import android.content.Intent;
import android.text.SpannableStringBuilder;
import android.text.Spanned;
import android.text.TextPaint;
import android.text.method.LinkMovementMethod;
import android.text.style.ClickableSpan;
import android.text.style.ForegroundColorSpan;
import android.view.View;
import android.widget.TextView;

import com.anthony.rvhelper.adapter.CommonAdapter;
import com.anthony.rvhelper.base.ViewHolder;
import com.app.base.bean.DynamicComment;
import com.app.base.utils.CommonKey;
import com.app.base.utils.GlideRoundTransform;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.bumptech.glide.request.RequestOptions;
import com.common.lib.utils.ToastUtils;

import app.odp.qidu.R;


public class DynamicReplyListAdapter extends CommonAdapter<DynamicComment> {

    private Activity activity;
    private RequestOptions options = null;
    private View.OnClickListener clickListener;
    private View.OnLongClickListener longClickListener;
    private int parentPosition;
    public DynamicReplyListAdapter(final Activity context,int parentPosition,View.OnClickListener clickListener,View.OnLongClickListener longClickListener) {
        super(context, R.layout.layout_dynamic_reply);
        this.activity=context;
        this.parentPosition=parentPosition;
        this.clickListener=clickListener;
        this.longClickListener=longClickListener;
        options = new RequestOptions()
                .centerCrop()
                .transform(new GlideRoundTransform(mContext))
                .diskCacheStrategy(DiskCacheStrategy.ALL);
    }

    @Override
    protected void convert(ViewHolder holder, final DynamicComment data, int position) {
        TextView content=holder.getView(R.id.tv_item_title);
        content.setText("");
        //content.setMovementMethod(LinkMovementClickMethod.getInstance());
        if(data.getReply_id()==null&&data.getReply_id().equals("0")){
            String reply = data.getMy_name();
            String all = reply + ":"+ data.getContent();
            SpannableStringBuilder builder = new SpannableStringBuilder(all);
            builder.setSpan(new ForegroundColorSpan(activity.getResources().getColor(R.color.blue)), 0, reply.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
            builder.setSpan(new ForegroundColorSpan(activity.getResources().getColor(R.color.black)), reply.length() - 1, all.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
            /*builder.setSpan(new ClickableSpan() {
                @Override
                public void onClick(View widget) {
                    if (clickListener != null) {
                        widget.setTag(CommonKey.KEY_POSITION, parentPosition);
                        widget.setTag(CommonKey.KEY_COMMENT_DYNAMIC_DATA, data);
                        clickListener.onClick(widget);
                    }
                }

                @Override
                public void updateDrawState(TextPaint ds) {
                    ds.setColor(activity.getResources().getColor(R.color.black));
                    ds.setUnderlineText(false);
                }
            }, reply.length() - 1, all.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);*/
            content.setText(builder);
        }else {
            String reply = data.getMy_name();
            String replyStr = reply+ "回复";
            String replyWho=replyStr+data.getReply_name();
            String all = replyWho + ":"+ data.getContent();
            SpannableStringBuilder builder = new SpannableStringBuilder(all);
            builder.setSpan(new ForegroundColorSpan(activity.getResources().getColor(R.color.blue)), 0, reply.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
            builder.setSpan(new ForegroundColorSpan(activity.getResources().getColor(R.color.black)), reply.length(), replyStr.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
            builder.setSpan(new ForegroundColorSpan(activity.getResources().getColor(R.color.blue)), replyStr.length(), replyWho.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
            builder.setSpan(new ForegroundColorSpan(activity.getResources().getColor(R.color.black)), replyWho.length(), all.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
            /*builder.setSpan(new ClickableSpan() {
                @Override
                public void onClick(View widget) {
                    if (clickListener != null) {
                        widget.setTag(CommonKey.KEY_POSITION, parentPosition);
                        widget.setTag(CommonKey.KEY_COMMENT_DYNAMIC_DATA, data);
                        clickListener.onClick(widget);
                    }
                }

                @Override
                public void updateDrawState(TextPaint ds) {
                    ds.setColor(activity.getResources().getColor(R.color.black));
                    ds.setUnderlineText(false);
                }
            }, replyWho.length(), all.length(), Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);*/
            content.setText(builder);
        }
        holder.getConvertView().setOnClickListener(v -> {
            if (clickListener != null) {
                v.setTag(CommonKey.KEY_POSITION, parentPosition);
                v.setTag(CommonKey.KEY_COMMENT_DYNAMIC_DATA, data);
                clickListener.onClick(v);
            }
        });
        holder.getConvertView().setOnLongClickListener(new View.OnLongClickListener() {
            @Override
            public boolean onLongClick(View v) {
                if(longClickListener!=null){
                    v.setTag(CommonKey.KEY_POSITION, parentPosition);
                    v.setTag(CommonKey.KEY_COMMENT_DYNAMIC_DATA, position);
                    longClickListener.onLongClick(v);
                }
                return false;
            }
        });
    }

}
