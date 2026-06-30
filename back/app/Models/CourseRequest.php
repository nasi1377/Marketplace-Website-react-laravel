class CourseRequest extends Model
{
    protected $fillable = [
        'course_id',
        'user_id',
        'status'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}