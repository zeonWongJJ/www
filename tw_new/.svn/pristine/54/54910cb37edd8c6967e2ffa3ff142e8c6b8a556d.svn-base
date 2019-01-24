package com.gzqx.common.widget;

import android.content.Context;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.Paint;
import android.graphics.Rect;
import android.graphics.RectF;
import android.graphics.Typeface;
import android.util.AttributeSet;
import android.widget.EditText;


import com.gzqx.com.gzqx.org.common.R;

import java.util.ArrayList;
import java.util.List;


/**
 * Created by 7du-28 on 2017/7/24.
 */

public class PhoneEditText extends EditText
{

    /**
     * 间隔
     */
    private final int Phone_SPACING = 10;

    /**
     * 手机大小
     */
    private final int Phone_SIZE = 50;

    /**
     * 手机号长度
     */
    private final int Phone_LENGTH = 11;

    private final int GRID_COLUMN = 4;//每行列数

    /**
     * 上下文
     */
    private Context mContext;

    /**
     * 宽度
     */
    private int mWidth;

    /**
     * 高度
     */
    private int mHeight;

    /**
     * 手机框
     */
    private Rect mRect;

    /**
     * 手机画笔
     */
    private Paint mPhonePaint;

    /**
     * 手机框画笔
     */
    private Paint mRectPaint;
    //模拟光标
    private Paint mTipPaint;
    /**
     * 输入的手机长度
     */
    private int mInputLength;

    private int rectWidth;
    private int rectHeight;

    private String s;
    private float roundPx=10f;
    private List<String> list = new ArrayList<String>();

    /**
     * 输入结束监听
     */
    private OnInputFinishListener mOnInputFinishListener;

    /**
     * 构造方法
     *
     * @param context
     * @param attrs
     */
    public PhoneEditText(Context context, AttributeSet attrs)
    {
        super(context, attrs);

        // 初始化手机画笔
        mPhonePaint = new Paint();
        mPhonePaint.setColor(Color.BLACK);
        mPhonePaint.setStyle(Paint.Style.FILL);
        mPhonePaint.setAntiAlias(true);
        mPhonePaint.setTextSize(Phone_SIZE);
        mPhonePaint.setTypeface(Typeface.DEFAULT);
        mPhonePaint.setColor(context.getResources().getColor(R.color.black));
        // 初始化手机框
        mRectPaint = new Paint();
        mRectPaint.setStyle(Paint.Style.STROKE);
        mRectPaint.setColor(Color.LTGRAY);
        mRectPaint.setAntiAlias(true);
        mRectPaint.setStrokeJoin(Paint.Join.ROUND); //圆角
        mRectPaint.setStrokeCap(Paint.Cap.ROUND);

        mTipPaint= new Paint();
        mTipPaint.setColor(Color.RED);
        mTipPaint.setStrokeWidth((float) 2.0);
        mTipPaint.setAntiAlias(true);
    }

    @Override
    protected void onDraw(Canvas canvas)
    {
        super.onDraw(canvas);
        mWidth = getMeasuredWidth();
        mHeight = getMeasuredHeight();

        // 这三行代码非常关键，大家可以注释点在看看效果
        Paint paint = new Paint();
        paint.setColor(Color.WHITE);
        canvas.drawRect(0, 0, mWidth, mHeight, paint);

        // 计算每个手机框宽度
        rectWidth = (mWidth - Phone_SPACING * (GRID_COLUMN - 1)) / GRID_COLUMN;
        //rectHeight=(mHeight ) / 3;
        rectHeight=rectWidth;
        // 绘制手机框
        for (int i = 0; i < Phone_LENGTH; i++)
        {
            if(i==mInputLength){
                mRectPaint.setColor(Color.RED);

            }else {
                mRectPaint.setColor(Color.LTGRAY);
            }
            if(i>2&&i<=6) {//第二行
                int left = (rectWidth + Phone_SPACING) * (i-3);
                int top = rectHeight+ Phone_SPACING;
                int right = left + rectWidth;
                int bottom = rectHeight*2;
                mRect = new Rect(left, top, right, bottom);
                RectF rectF = new RectF(mRect);
                canvas.drawRoundRect(rectF, roundPx, roundPx, mRectPaint);
            }else if(i>6){//第三行
                int left = (rectWidth + Phone_SPACING) * (i-7);
                int top = rectHeight*2+ Phone_SPACING;
                int right = left + rectWidth;
                int bottom = rectHeight*3;
                mRect = new Rect(left, top, right, bottom);
                RectF rectF = new RectF(mRect);
                canvas.drawRoundRect(rectF, roundPx, roundPx, mRectPaint);
            }else {//第一行
                int left = (rectWidth + Phone_SPACING) * i;
                int top = 2;
                int right = left + rectWidth;
                int bottom = rectHeight;
                mRect = new Rect(left, top, right, bottom);
                RectF rectF = new RectF(mRect);
                canvas.drawRoundRect(rectF, roundPx, roundPx, mRectPaint);
            }
        }

        if(mInputLength==0){
            int startX = rectWidth / 2;
            int startY=rectHeight/2-20;
            int stopY=rectHeight/2+20;
            canvas.drawLine(startX,startY,startX,stopY,mTipPaint);
        }
        // 绘制手机号码
        for (int i = 0; i < mInputLength; i++)
        {
            if(i>2&&i<=6){//第二行
                int cx = rectWidth / 2 + (rectWidth + Phone_SPACING) * (i-3) - 10;
                int cy = rectHeight+rectHeight/2+20;
                canvas.drawText(list.get(i), cx, cy, mPhonePaint);
            }else if(i>6){//第三行
                int cx = rectWidth / 2 + (rectWidth + Phone_SPACING) * (i-7) - 10;
                int cy = rectHeight*2+rectHeight/2+20;
                canvas.drawText(list.get(i), cx, cy, mPhonePaint);
            }else {//第一行
                int cx = rectWidth / 2 + (rectWidth + Phone_SPACING) * i - 10;
                int cy = rectHeight/2+20;
                canvas.drawText(list.get(i), cx, cy, mPhonePaint);
            }

            //绘制光标位置
            if((mInputLength<Phone_LENGTH&&(i+1)==mInputLength)){//第一行
                if(i<2){
                    int startX = rectWidth / 2 + (rectWidth + Phone_SPACING) * (i+1);
                    int startY=rectHeight/2-20;
                    int stopY=rectHeight/2+20;
                    canvas.drawLine(startX,startY,startX,stopY,mTipPaint);
                }else if(i>=2&&i<6){
                    int startX = rectWidth / 2 + (rectWidth + Phone_SPACING) * (i-2);
                    int startY=rectHeight+rectHeight/2-20;
                    int stopY=rectHeight+rectHeight/2+20;
                    canvas.drawLine(startX,startY,startX,stopY,mTipPaint);
                }else if(i>=6&&i<Phone_LENGTH-1){
                    int startX = rectWidth / 2 + (rectWidth + Phone_SPACING) * (i-6);
                    int startY=rectHeight*2+rectHeight/2-20;
                    int stopY=rectHeight*2+rectHeight/2+20;
                    canvas.drawLine(startX,startY,startX,stopY,mTipPaint);
                }
            }
        }
    }

    @Override
    protected void onTextChanged(CharSequence text, int start, int lengthBefore, int lengthAfter)
    {
        super.onTextChanged(text, start, lengthBefore, lengthAfter);

        this.mInputLength = text.toString().length();
        if (list != null && list.size() > 0)
        {
            list.clear();
        }
        for (int i = 0; i < mInputLength; i++)
        {
            list.add(text.toString().substring(i, i + 1));
        }

        invalidate();
        if (mInputLength == Phone_LENGTH && mOnInputFinishListener != null)
        {
            mOnInputFinishListener.onInputFinish(text.toString());
        }
    }

    public interface OnInputFinishListener
    {
        /**
         * 手机输入结束监听
         *
         * @param password
         */
        void onInputFinish(String phonenumber);
    }

    /**
     * 设置输入完成监听
     *
     * @param onInputFinishListener
     */
    public void setOnInputFinishListener(OnInputFinishListener onInputFinishListener)
    {
        this.mOnInputFinishListener = onInputFinishListener;
    }

}
