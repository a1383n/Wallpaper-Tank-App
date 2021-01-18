package ir.amirsobhan.wallpaperapp.Databases;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import androidx.annotation.Nullable;

import ir.amirsobhan.wallpaperapp.Model.Category;

public class CategoryDB extends SQLiteOpenHelper {
    private final static int DB_VERSION = 1;
    private final static String DB_NAME = "categoryDB";
    public final static String TABLE_NAME = "category";
    public final static String KEY_ID = "id";
    public final static String ITEM_NAME = "name";
    public final static String ITEM_TITLE = "title";
    public final static String ITEM_COLOR = "color";
    public final static String ITEM_COUNT = "count";
    private final static String CREATE_TABLE = "CREATE TABLE " + TABLE_NAME + "("
            + KEY_ID + " INTEGER PRIMARY KEY AUTOINCREMENT,"
            + ITEM_NAME + " TEXT,"
            + ITEM_TITLE + " TEXT,"
            + ITEM_COLOR + " TEXT,"
            + ITEM_COUNT + " TEXT)";

    public CategoryDB(@Nullable Context context) {
        super(context, DB_NAME, null, DB_VERSION);
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        db.execSQL(CREATE_TABLE);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {

    }

    /**
     * Insert New Data
     *
     * @param category
     */
    public void Insert(Category category) {
        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues values = new ContentValues();
        values.put(KEY_ID, category.getId());
        values.put(ITEM_NAME, category.getName());
        values.put(ITEM_TITLE, category.getName());
        values.put(ITEM_COLOR, category.getColor());
        values.put(ITEM_COUNT, category.getItemsCount());
        db.insert(TABLE_NAME, null, values);
    }

    /**
     * Check data exist or not
     *
     * @param id
     * @return
     */
    public boolean isExist(int id) {
        SQLiteDatabase db = this.getReadableDatabase();
        String sql = "SELECT * FROM " + TABLE_NAME + " WHERE " + KEY_ID + "=" + id;
        Cursor cursor = db.rawQuery(sql, null, null);
        return cursor.getCount() > 0;
    }
}
