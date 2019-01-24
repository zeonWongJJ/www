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
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.app.base.R;
import com.common.lib.utils.ToastUtils;


/**
 * 删除按钮在右上角的 普通alertDialog
 */

public class EditNodeDialog extends Dialog {

    private EditNodeDialog(Context context) {
        super(context);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        this.getWindow().setBackgroundDrawableResource(android.R.color.transparent);
    }

    @Override
    protected void onStart() {
        super.onStart();
        getWindow().setLayout(ViewGroup.LayoutParams.WRAP_CONTENT, ViewGroup.LayoutParams.WRAP_CONTENT);
    }

    public static EditNodeDialog show(Context context, String title, String msg, String ok, String cancel, Drawable icon,
                                      final OnClickListener cancelListener, boolean cancelable) {
        final EditNodeDialog dialog = new EditNodeDialog(context);

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

    public static EditNodeDialog show(Context context, String title, String msg, String ok, String cancel, int iconId,
                                      final OnClickListener cancelListener, boolean cancelable) {
        Drawable drawable = context.getResources().getDrawable(iconId);
        return show(context, title, msg, ok, cancel, drawable, cancelListener, cancelable);
    }

    public interface OnClickListener {
        public void onOkClick(String editContent);

        public void onCancelClick();

        public void onDismiss();
    }


    private static View initView(Context context, String title, String msg, String ok, String cancel, Drawable icon, boolean cancelable,
                                 final OnClickListener clickListener, final Dialog dialog) {
        View rootView = LayoutInflater.from(context).inflate(R.layout.layout_edit_node_dialog, null);
        TextView tvTitle = (TextView) rootView.findViewById(R.id.tv_m_view_app_dialog_p_title);
        final EditText tvMsg = (EditText) rootView.findViewById(R.id.tv_m_view_app_dialog_p_msg);
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
            tvMsg.setText("");
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
                if(TextUtils.isEmpty(tvMsg.getText().toString().trim())){
                    ToastUtils.show("内容不能为空");
                    return;
                }
                if (clickListener != null) {
                    clickListener.onOkClick(tvMsg.getText().toString());
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

        public EditNodeDialog create() {
            if (iconId != 0) {
                return EditNodeDialog.show(context, title, msg, ok, cancel, iconId, clickListener, cancelable);
            } else if (icon != null) {
                return EditNodeDialog.show(context, title, msg, ok, cancel, icon, clickListener, cancelable);
            } else {
                return EditNodeDialog.show(context, title, msg, ok, cancel, null, clickListener, cancelable);
            }
        }
    }


}
