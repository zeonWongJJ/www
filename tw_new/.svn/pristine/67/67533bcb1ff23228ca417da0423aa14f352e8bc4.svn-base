package sj.keyboard.widget;

import android.content.Context;
import android.os.Bundle;
import android.support.v13.view.inputmethod.EditorInfoCompat;
import android.support.v13.view.inputmethod.InputConnectionCompat;
import android.support.v13.view.inputmethod.InputContentInfoCompat;
import android.util.AttributeSet;
import android.view.KeyEvent;
import android.view.inputmethod.EditorInfo;
import android.view.inputmethod.InputConnection;
import android.widget.EditText;

import java.util.ArrayList;
import java.util.List;

import sj.keyboard.interfaces.EmoticonFilter;

public class EmoticonsEditText extends EditText {

    private List<EmoticonFilter> mFilterList;

    public EmoticonsEditText(Context context) {
        this(context, null);
    }

    public EmoticonsEditText(Context context, AttributeSet attrs) {
        this(context, attrs, 0);
    }

    public EmoticonsEditText(Context context, AttributeSet attrs, int defStyle) {
        super(context, attrs, defStyle);
    }

    @Override
    protected void onMeasure(int widthMeasureSpec, int heightMeasureSpec) {
        try {
            super.onMeasure(widthMeasureSpec, heightMeasureSpec);
        } catch (ArrayIndexOutOfBoundsException e) {
            setText(getText().toString());
            super.onMeasure(widthMeasureSpec, heightMeasureSpec);
        }
    }

    @Override
    protected void onSizeChanged(int w, int h, int oldw, int oldh) {
        super.onSizeChanged(w, h, oldw, oldh);
        if(oldh > 0 && onSizeChangedListener != null){
            onSizeChangedListener.onSizeChanged(w, h, oldw, oldh);
        }
    }

    @Override
    public void setGravity(int gravity) {
        try {
            super.setGravity(gravity);
        } catch (ArrayIndexOutOfBoundsException e) {
            setText(getText().toString());
            super.setGravity(gravity);
        }
    }

    @Override
    public void setText(CharSequence text, BufferType type) {
        try {
            super.setText(text, type);
        } catch (ArrayIndexOutOfBoundsException e) {
            setText(text.toString());
        }
    }

    @Override
    protected final void onTextChanged(CharSequence arg0, int start, int lengthBefore, int after) {
        super.onTextChanged(arg0, start, lengthBefore, after);
        if(mFilterList == null){
            return;
        }
        for(EmoticonFilter emoticonFilter : mFilterList) {
            emoticonFilter.filter(this, arg0, start, lengthBefore, after);
        }
    }

    public void addEmoticonFilter(EmoticonFilter emoticonFilter){
        if(mFilterList == null){
            mFilterList = new ArrayList<>();
        }
        mFilterList.add(emoticonFilter);
    }

    public void removedEmoticonFilter(EmoticonFilter emoticonFilter){
        if(mFilterList != null && mFilterList.contains(emoticonFilter)){
            mFilterList.remove(emoticonFilter);
        }
    }

    @Override
    public boolean dispatchKeyEventPreIme(KeyEvent event) {
        if(onBackKeyClickListener != null){
            onBackKeyClickListener.onBackKeyClick();
        }
        return super.dispatchKeyEventPreIme(event);
    }

    public interface OnBackKeyClickListener {
        void onBackKeyClick();
    }

    OnBackKeyClickListener onBackKeyClickListener;

    public void setOnBackKeyClickListener(OnBackKeyClickListener i) {
        onBackKeyClickListener = i;
    }

    public interface OnSizeChangedListener {
        void onSizeChanged(int w, int h, int oldw, int oldh);
    }

    OnSizeChangedListener onSizeChangedListener;

    public void setOnSizeChangedListener(OnSizeChangedListener i) {
        onSizeChangedListener = i;
    }


    private final String[] mimeTypes = {"image/gif"};
    final InputConnectionCompat.OnCommitContentListener inputConnectionListener =
            new InputConnectionCompat.OnCommitContentListener() {
                @Override
                public boolean onCommitContent(InputContentInfoCompat inputContentInfo, int flags,
                                               Bundle opts) {
                    if (listener != null) {
                        return listener.onCommitContent(inputContentInfo, flags, opts, mimeTypes);
                    }

                    return false;
                }
            };

    private OnCommitContentListener listener;
    @Override
    public InputConnection onCreateInputConnection(EditorInfo editorInfo) {
        final InputConnection inputConnection = super.onCreateInputConnection(editorInfo);
        if (inputConnection == null) {
            return null;
        }

        EditorInfoCompat.setContentMimeTypes(editorInfo, mimeTypes);

        return InputConnectionCompat
                .createWrapper(inputConnection, editorInfo, inputConnectionListener);
    }

    public void setContentListener(OnCommitContentListener listener) {
        this.listener = listener;
    }

    public interface OnCommitContentListener {
        boolean onCommitContent(InputContentInfoCompat inputContentInfo, int flags,
                                Bundle opts, String[] supportedMimeTypes);
    }
}
