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
import android.widget.TextView;

import com.app.base.R;


/**
 * 删除按钮在右上角的 普通alertDialog
 */

public class RightAlertDialog extends Dialog {

    private RightAlertDialog(Context context) {
        super(context);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        this.getWindow().setBackgroundDrawableResource(android.R.color.transparent);
    }

    @Override
    protected void onStart() {
        super.onStart();
        getWindow().setLayout(ViewGroup.LayoutParams.WRAP_CONTENT, ViewGroup.LayoutParams.WRAP_CONTENT);
    }

    public static RightAlertDialog show(Context context, String title, String msg, String ok, String cancel, Drawable icon,
                                        final OnClickListener cancelListener, boolean cancelable) {
        final RightAlertDialog dialog = new RightAlertDialog(context);

        View view = initView(context, title, msg, ok, cancel, icon, cancelable, cancelListener, dialog);
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

    public static RightAlertDialog show(Context context, String title, String msg, String ok, String cancel, int iconId,
                                        final OnClickListener cancelListener, boolean cancelable) {
        Drawable drawable = context.getResources().getDrawable(iconId);
        return show(context, title, msg, ok, cancel, drawable, cancelListener, cancelable);
    }

    public interface OnClickListener {
        public void onOkClick();

        public void onCancelClick();

        public void onDismiss();
    }


    private static View initView(Context context, String title, String msg, String ok, String cancel, Drawable icon, boolean cancelable,
                                 final OnClickListener clickListener, final Dialog dialog) {
        View rootView = LayoutInflater.from(context).inflate(R.layout.layout_right_app_dialog, null);
        TextView tvTitle = (TextView) rootView.findViewById(R.id.tv_m_view_app_dialog_p_title);
        TextView tvMsg = (TextView) rootView.findViewById(R.id.tv_m_view_app_dialog_p_msg);
        TextView tvPositive = (TextView) rootView.findViewById(R.id.tv_m_view_app_dialog_p_positive);
        ImageView tvNegative = (ImageView) rootView.findViewById(R.id.tv_m_view_app_dialog_p_negative);
        View top = rootView.findViewById(R.id.ll_m_view_app_dialog_p_title);
        //View dividerHorizontal = rootView.findViewById(R.id.view_m_view_app_dialog_p_divider_horizontal);
        //View dividerVertical = rootView.findViewById(R.id.view_m_view_app_dialog_p_divider_vertical);
        ImageView ivIcon = (ImageView) rootView.findViewById(R.id.iv_m_view_app_dialog_p_icon);

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
        if (!TextUtils.isEmpty(msg)) {
            tvMsg.setText(msg);
        } else {
            tvMsg.setVisibility(View.GONE);
            //dividerHorizontal.setVisibility(View.GONE);
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
                    clickListener.onOkClick();
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

        return rootView;
    }

    public static class Builder {
        private Context context;
        private String title, msg, ok, cancel;
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

        public RightAlertDialog create() {
            if (iconId != 0) {
                return RightAlertDialog.show(context, title, msg, ok, cancel, iconId, clickListener, cancelable);
            } else if (icon != null) {
                return RightAlertDialog.show(context, title, msg, ok, cancel, icon, clickListener, cancelable);
            } else {
                return RightAlertDialog.show(context, title, msg, ok, cancel, null, clickListener, cancelable);
            }
        }
    }


}
