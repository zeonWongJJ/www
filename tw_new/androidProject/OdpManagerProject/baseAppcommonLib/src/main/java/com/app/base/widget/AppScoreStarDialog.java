package com.app.base.widget;

import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.graphics.drawable.Drawable;
import android.text.TextUtils;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RatingBar;
import android.widget.TextView;

import com.app.base.R;
import com.app.base.utils.DataUtils;


/**
 * 星星评分弹框
 */

public class AppScoreStarDialog extends Dialog {

    private AppScoreStarDialog(Context context) {
        super(context);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        this.getWindow().setBackgroundDrawableResource(android.R.color.transparent);
    }

    @Override
    protected void onStart() {
        super.onStart();
        getWindow().setLayout(ViewGroup.LayoutParams.WRAP_CONTENT, ViewGroup.LayoutParams.WRAP_CONTENT);
    }

    public static AppScoreStarDialog show(Context context, String title, String msg,String defaultScore, String ok, String cancel, Drawable icon,
                                          final OnClickListener cancelListener, boolean cancelable) {
        final AppScoreStarDialog dialog = new AppScoreStarDialog(context);

        View view = initView(context, title, msg,defaultScore, ok, cancel, icon, cancelable, cancelListener, dialog);
        dialog.setOnCancelListener(new OnCancelListener() {
            @Override
            public void onCancel(DialogInterface dialog) {
                if (cancelListener != null) {
                    cancelListener.onDismiss();
                }
            }
        });
        dialog.setContentView(view);
        dialog.setCancelable(cancelable);
        dialog.show();
        return dialog;
    }

    public static AppScoreStarDialog show(Context context, String title, String msg,String defaultScore, String ok, String cancel, int iconId,
                                          final OnClickListener cancelListener, boolean cancelable) {
        Drawable drawable = context.getResources().getDrawable(iconId);
        return show(context, title, msg,defaultScore, ok, cancel, drawable, cancelListener, cancelable);
    }

    public interface OnClickListener {
        public void onOkClick(float order_score,String level);

        public void onCancelClick();

        public void onDismiss();
    }


    private static View initView(Context context, String title, String msg,String defaultScore, String ok, String cancel, Drawable icon, boolean cancelable,
                                 final OnClickListener clickListener, final Dialog dialog) {
        View rootView = LayoutInflater.from(context).inflate(R.layout.layout_app_score_star_dialog, null);
        final RatingBar plan_order_score=rootView.findViewById(R.id.plan_order_score);

        TextView tvTitle = (TextView) rootView.findViewById(R.id.tv_m_view_app_dialog_p_title);
        TextView tvPositive = (TextView) rootView.findViewById(R.id.tv_m_view_app_dialog_p_positive);
        ImageView tvNegative = (ImageView) rootView.findViewById(R.id.tv_m_view_app_dialog_p_negative);
        View top = rootView.findViewById(R.id.ll_m_view_app_dialog_p_title);
        ImageView ivIcon = (ImageView) rootView.findViewById(R.id.iv_m_view_app_dialog_p_icon);
        final TextView num_order_score=rootView.findViewById(R.id.num_order_score);
        if (icon != null) {
            ivIcon.setImageDrawable(icon);
            top.setVisibility(View.VISIBLE);
        } else {
            ivIcon.setVisibility(View.GONE);
            LinearLayout.LayoutParams lp = (LinearLayout.LayoutParams) tvTitle.getLayoutParams();
            lp.width = LinearLayout.LayoutParams.WRAP_CONTENT;
            tvTitle.setLayoutParams(lp);
        }
        if (!TextUtils.isEmpty(title)) {
            tvTitle.setText(title);
            top.setVisibility(View.VISIBLE);
        }
        if (!TextUtils.isEmpty(ok)) {
            tvPositive.setText(ok);
        } else {
            tvPositive.setVisibility(View.GONE);
            //dividerVertical.setVisibility(View.INVISIBLE);

        }
        if (!TextUtils.isEmpty(cancel)) {
            //tvNegative.setText(cancel);
            tvNegative.setVisibility(View.VISIBLE);
        } else {
            tvNegative.setVisibility(View.GONE);
        }
        /*if (TextUtils.isEmpty(ok) && TextUtils.isEmpty(cancel)) {
            //dividerVertical.setVisibility(View.GONE);
            //dividerHorizontal.setVisibility(View.GONE);
        }*/
        tvPositive.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                if (clickListener != null) {
                    float rating=plan_order_score.getRating();
                    String level= DataUtils.getLevelByNum(rating);
                    clickListener.onOkClick(plan_order_score.getRating(),level);
                }
                dialog.dismiss();
            }
        });
        tvNegative.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                if (clickListener != null) {
                    clickListener.onCancelClick();
                }
                dialog.dismiss();
            }
        });
        if(!TextUtils.isEmpty(defaultScore)){
            num_order_score.setText(DataUtils.getLevelByNum(Float.parseFloat(defaultScore)));
            plan_order_score.setRating(Float.parseFloat(defaultScore));
        }
        plan_order_score.setOnRatingBarChangeListener(new RatingBar.OnRatingBarChangeListener() {
            @Override
            public void onRatingChanged(RatingBar ratingBar, float rating, boolean fromUser) {
                String level= DataUtils.getLevelByNum(rating);
                num_order_score.setText(""+level);
            }
        });
        return rootView;
    }

    public static class Builder {
        private Context context;
        private String title, msg, ok, cancel,defaultScore;
        private boolean cancelable;
        private OnClickListener clickListener;
        private int iconId;
        private Drawable icon;
        private Dialog dialog;

        public Builder(Context context) {
            this.context = context;
            cancelable = true;
        }

        public Builder setTitle(String title) {
            this.title = title;
            return this;
        }

        public Builder setTitle(int titleId) {
            this.title = context.getResources().getString(titleId);
            return this;
        }

        public Builder setMsg(String msg) {
            this.msg = msg;
            return this;
        }
        public Builder setDefaultScore(String defaultScore){
            this.defaultScore=defaultScore;
            return this;
        }

        public Builder setMsg(int msgId) {
            this.msg = context.getResources().getString(msgId);
            return this;
        }

        public Builder setOk(String ok) {
            this.ok = ok;
            return this;
        }

        public Builder setCancel(String cancel) {
            this.cancel = cancel;
            return this;
        }

        public Builder setCancelable(boolean cancelable) {
            this.cancelable = cancelable;
            return this;
        }

        public Builder setClickListener(OnClickListener clickListener) {
            this.clickListener = clickListener;
            return this;
        }

        public Builder setIcon(Drawable icon) {
            this.icon = icon;
            return this;
        }

        public Builder setIconId(int iconId) {
            this.iconId = iconId;
            return this;
        }

        public AppScoreStarDialog create() {
            if (iconId != 0) {
                return AppScoreStarDialog.show(context, title, msg,defaultScore, ok, cancel, iconId, clickListener, cancelable);
            } else if (icon != null) {
                return AppScoreStarDialog.show(context, title, msg,defaultScore, ok, cancel, icon, clickListener, cancelable);
            } else {
                return AppScoreStarDialog.show(context, title, msg,defaultScore, ok, cancel, null, clickListener, cancelable);
            }
        }
    }


}
