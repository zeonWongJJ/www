package app.vdao.qidu.widget;

import android.app.Dialog;
import android.content.Context;
import android.text.TextUtils;
import android.view.Display;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.GridView;
import android.widget.TextView;

import com.qidu.chat.widget.VirtualKeyboardView;

import app.vdao.qidu.R;

import java.util.ArrayList;
import java.util.Map;

/**
 * 价格输入弹出框
 */

public class InputPriceDialog implements View.OnClickListener{
    private Context context;
    private Dialog dialog;
    private Display display;
    private TextView txt_title,price;
    private Button btnSubmit, btnCancel; //确定、取消按钮
    private static final String TAG_SUBMIT = "submit";
    private static final String TAG_CANCEL = "cancel";
    private ArrayList<Map<String, String>> valueList;

    public InputPriceDialog(Context context) {
        this.context = context;
        WindowManager windowManager = (WindowManager) context
                .getSystemService(Context.WINDOW_SERVICE);
        display = windowManager.getDefaultDisplay();
    }

    public InputPriceDialog builder() {
        View view = LayoutInflater.from(context).inflate(
                R.layout.layout_input_price, null);

        view.setMinimumWidth(display.getWidth());

        //sLayout_content = (ScrollView) view.findViewById(R.id.sLayout_content);
        txt_title = (TextView) view.findViewById(R.id.tvTitle);
        price=view.findViewById(R.id.price);
        //确定和取消按钮
        btnSubmit = (Button) view.findViewById(R.id.btnSubmit);
        btnCancel = (Button) view.findViewById(R.id.btnCancel);
        btnSubmit.setTag(TAG_SUBMIT);
        btnCancel.setTag(TAG_CANCEL);
        btnSubmit.setOnClickListener(this);
        btnCancel.setOnClickListener(this);
        //设置文字
        btnSubmit.setText(context.getResources().getString(R.string.pickerview_submit));
        btnCancel.setText(context.getResources().getString(R.string.pickerview_cancel));
        VirtualKeyboardView virtualKeyboardView= (VirtualKeyboardView) view.findViewById(R.id.virtual_keyboard_view);
        virtualKeyboardView.getLayoutBack().setVisibility(View.GONE);
        virtualKeyboardView.getLine().setVisibility(View.GONE);

        GridView gridView = virtualKeyboardView.getGridView();
        gridView.setOnItemClickListener(onItemClickListener);
        valueList = virtualKeyboardView.getValueList();

        dialog = new Dialog(context, R.style.ActionSheetDialogStyle);
        dialog.setContentView(view);
        Window dialogWindow = dialog.getWindow();
        dialogWindow.setGravity(Gravity.LEFT | Gravity.BOTTOM);
        WindowManager.LayoutParams lp = dialogWindow.getAttributes();
        lp.x = 0;
        lp.y = 0;
        dialogWindow.setAttributes(lp);

        return this;
    }



    public InputPriceDialog setTitle(String title) {
        txt_title.setVisibility(View.VISIBLE);
        txt_title.setText(title);
        return this;
    }
    public void show() {
        dialog.show();
    }
    public InputPriceDialog setCancelable(boolean cancel) {
        dialog.setCancelable(cancel);
        return this;
    }
    public InputPriceDialog setCanceledOnTouchOutside(boolean cancel) {
        dialog.setCanceledOnTouchOutside(cancel);
        return this;
    }
    @Override
    public void onClick(View v) {
        String tag = (String) v.getTag();
        if (tag.equals(TAG_SUBMIT)) {
            if(TextUtils.isEmpty(price.getText().toString())){
                txt_title.setTextColor(context.getResources().getColor(R.color.yellow_line_color));
                txt_title.setText("单价不能为空");
                return;
            }
            if(this.listener!=null){
                listener.onEditInputResult(price.getText().toString());
            }
        }
        dialog.dismiss();
    }
    public interface OnEditListener{
        void onEditInputResult(String content);
    }
    private OnEditListener listener;
    public InputPriceDialog setOnEditListener(OnEditListener listener){
        this.listener=listener;
        return this;
    }
    private AdapterView.OnItemClickListener onItemClickListener = new AdapterView.OnItemClickListener() {

        @Override
        public void onItemClick(AdapterView<?> adapterView, View view, int position, long l) {

            if (position == 11) {      //点击退格键
                String amount = price.getText().toString().trim();
                if (amount.length() > 0) {
                    amount = amount.substring(0, amount.length() - 1);
                    price.setText(amount);
                }
            }

            if(price.getText().toString().trim().length()>10){//大于十个字符不让输入了
                return;
            }
            txt_title.setTextColor(context.getResources().getColor(R.color.black));
            txt_title.setText("请输入单价");
            if (position < 11 && position != 9) {    //点击0~9按钮
                String amount = price.getText().toString().trim();
                amount = amount + valueList.get(position).get("name");
                price.setText(amount);
            } else {
                if (position == 9) {      //点击小数点键
                    String amount = price.getText().toString().trim();
                    if (!amount.contains(".")) {
                        amount = amount + valueList.get(position).get("name");
                        price.setText(amount);
                        /*Editable ea = textAmount.getText();
                        textAmount.setSelection(ea.length());*/
                    }
                    if(amount.startsWith(".")){
                        amount = "0" + valueList.get(position).get("name");
                        price.setText(amount);
                    }
                }

            }

            /*String s=price.getEditableText().toString().trim();
            Log.i("aaaaaaa",s);
            if(s == null || s.length() == 0){
                //price.setText("0.00");
                return;
            }
            if (s.toString().contains(".")) {
                if (s.length() - 1 - s.toString().indexOf(".") > 2) {
                    s = (String) s.subSequence(0,
                            s.indexOf(".") + 3);
                    price.setText(s);
                }
            }
            if (s.toString().trim().substring(0).equals(".")) {
                s = "0" + s;
                price.setText(s);
            }

            if (s.toString().startsWith("0")
                    && s.toString().trim().length() > 1) {
                if (!s.toString().substring(1, 2).equals(".")) {
                    price.setText(s.subSequence(0, 1));
                    return;
                }
            }

            if(s.toString().trim().substring(0,1).equals(".") || s.toString().trim().substring(s.toString().trim().length()-1,s.toString().trim().length()).equals(".")){
                //sendButton.setEnabled(false);
                return;
            }
            *//*judgeNumber(redPacketMoneyTotal.getEditableText());*//*
            if(price.getEditableText()!=null){
                String temp = price.getEditableText().toString();
                int posDot = temp.indexOf(".");//返回指定字符在此字符串中第一次出现处的索引
                if (posDot <= 0) {//不包含小数点
                    if (temp.length() > 5) {
                        price.getEditableText().delete(5, 6);//大于五位数就删掉第六位（只会保留五位）
                    }
                }else if(temp.length() - posDot - 1 > 2)//如果包含小数点
                {
                    price.getEditableText().delete(posDot + 3, posDot + 4);//删除小数点后的第三位
                }

            *//*String money=redPacketMoneyTotal.getText().toString();
            totalMoney.setText(money);*//*
            }*/

        }
    };
}
