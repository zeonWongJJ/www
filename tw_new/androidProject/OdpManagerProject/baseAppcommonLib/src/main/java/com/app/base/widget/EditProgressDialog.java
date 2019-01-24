package com.app.base.widget;

import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.graphics.drawable.Drawable;
import android.text.Editable;
import android.text.TextUtils;
import android.text.TextWatcher;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.widget.AdapterView;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;

import com.app.base.R;
import com.app.base.adapter.DialogAssignTaskAdapter;
import com.app.base.bean.UserRealm;
import com.common.lib.utils.ToastUtils;

import java.util.List;
import java.util.regex.Matcher;
import java.util.regex.Pattern;


/**
 * 编辑进度弹框
 */

public class EditProgressDialog extends Dialog {

    private EditProgressDialog(Context context) {
        super(context);
        this.requestWindowFeature(Window.FEATURE_NO_TITLE);
        this.getWindow().setBackgroundDrawableResource(android.R.color.transparent);
    }
    @Override
    protected void onStart() {
        super.onStart();
        getWindow().setLayout(ViewGroup.LayoutParams.WRAP_CONTENT, ViewGroup.LayoutParams.WRAP_CONTENT);
    }

    public static EditProgressDialog show(Context context, String title, String ok, String cancel, Drawable icon,
                                          final OnClickListener cancelListener, boolean cancelable) {
        final EditProgressDialog dialog = new EditProgressDialog(context);

        View view = initView(context, title,  ok, cancel, icon, cancelable, cancelListener, dialog);
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

    public static EditProgressDialog show(Context context, String title,String ok, String cancel, int iconId,
                                          final OnClickListener cancelListener, boolean cancelable) {
        Drawable drawable = context.getResources().getDrawable(iconId);
        return show(context, title, ok, cancel, drawable, cancelListener, cancelable);
    }

    public interface OnClickListener {
        public void onOkClick(String progress);

        public void onCancelClick();
        public void onItemClick(UserRealm data, int position);
        public void onDismiss();
    }


    private static View initView(Context context, String title, String ok, String cancel, Drawable icon, boolean cancelable,
                                 final OnClickListener clickListener, final Dialog dialog) {
        View rootView = LayoutInflater.from(context).inflate(R.layout.layout_edit_progress_dialog, null);
        TextView tvTitle = (TextView) rootView.findViewById(R.id.tv_m_view_app_dialog_p_title);
        final EditText editText = (EditText) rootView.findViewById(R.id.edit_progress);
        editText.addTextChangedListener(new TextWatcher() {
            String outStr="";
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {
                String edit=s.toString();
                if (edit.length()==2&&Integer.parseInt(edit)>=10){
                    outStr=edit;
                }
            }

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
                String words = s.toString();
                //首先内容进行非空判断，空内容（""和null）不处理
                if (!TextUtils.isEmpty(words)) {
                    //1-100的正则验证
                    Pattern p = Pattern.compile("^(100|[1-9]\\d|\\d)$");
                    Matcher m = p.matcher(words);
                    if (m.find() || ("").equals(words)) {
                        //这个时候输入的是合法范围内的值
                    } else {
                        if (words.length() > 2) {
                            //若输入不合规，且长度超过2位，继续输入只显示之前存储的outStr
                            editText.setText(outStr);
                            //重置输入框内容后默认光标位置会回到索引0的地方，要改变光标位置
                            editText.setSelection(2);
                        }
                        ToastUtils.show("请输入范围在1-100之间的整数");
                    }
                }
            }

            @Override
            public void afterTextChanged(Editable s) {
                //这里的处理是不让输入0开头的值
                String words = s.toString();
                //首先内容进行非空判断，空内容（""和null）不处理
                if (!TextUtils.isEmpty(words)) {
                    if (Integer.parseInt(s.toString()) <= 0) {
                        editText.setText("");
                        //ToastUtils.show("请输入范围在1-100之间的整数");
                    }
                }
            }
        });
        TextView tvPositive = (TextView) rootView.findViewById(R.id.tv_m_view_app_dialog_p_positive);
        ImageView tvNegative = (ImageView) rootView.findViewById(R.id.tv_m_view_app_dialog_p_negative);

        if (!TextUtils.isEmpty(title)) {
            tvTitle.setVisibility(View.VISIBLE);
            tvTitle.setText(title);
        }else {
            tvTitle.setVisibility(View.GONE);
        }

        if (!TextUtils.isEmpty(ok)) {
            tvPositive.setText(ok);
        } else {
            tvPositive.setVisibility(View.GONE);

        }

        tvPositive.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                if (clickListener != null) {
                    String progress=editText.getText().toString();
                    if(TextUtils.isEmpty(progress)){
                        ToastUtils.show("请输入进度");
                    }
                    clickListener.onOkClick(progress);
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
        private String title, ok, cancel;
        private boolean cancelable;
        private OnClickListener clickListener;
        private int iconId;
        private Drawable icon;

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

        public EditProgressDialog create() {
            if (iconId != 0) {
                return EditProgressDialog.show(context, title, ok, cancel, iconId, clickListener, cancelable);
            } else if (icon != null) {
                return EditProgressDialog.show(context, title,  ok, cancel, icon, clickListener, cancelable);
            } else {
                return EditProgressDialog.show(context, title,  ok, cancel, null, clickListener, cancelable);
            }
        }
    }


}
