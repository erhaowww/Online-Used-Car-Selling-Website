<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use Session;
use App\Models\Comment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class ReviewController extends Controller
{
    private $reviewRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = $this->reviewRepository->allReview();
        return view('admin/all-comment', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/add-comment');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        $images = array();
        $review_img = NULL;
        if ($files = $req->input('filepond')) {
            foreach ($files as $file) {
                $json_string = json_decode($file, true);
                $data_column = $json_string['data'];

                $image = base64_decode($data_column);
                $image_name = uniqid(rand(), false) . '.png';
                file_put_contents('../public/user/img/review/'.$image_name, $image);
                $images[] = $image_name;
            }
            $review_img = implode("|",$images);
        }

        $data = [
            'user_id' => auth()->user()->id,
            'payment_id' => $req->payment_id,
            'rating' => $req->rate_value,
            'review' => $req->review,
            'image' => $review_img
        ];
        $this->reviewRepository->storeReview($data);
        return redirect('user/payment-history')->with('add_review_message', 'Review and Rating has been added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $comment = $this->reviewRepository->findReview($id);
        return view('admin/add-edit-comment', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $data = [
            'comment' => $request->comment,
        ];
        $this->reviewRepository->updateReview($data, $id);

        return redirect('comments')->with('success', 'Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyReview(string $id)
    {
        $this->reviewRepository->destroyReview($id);

        return redirect('comments')->with('success', 'Information has been deleted');
    }

    public function review_page(){
        $average_rating = 0;
        $total_review = 0;
        $five_star_review = 0;
        $four_star_review = 0;
        $three_star_review = 0;
        $two_star_review = 0;
        $one_star_review = 0;
        $total_user_rating = 0;
        $review_content = array();

        $comments = $this->reviewRepository->allReview();

        foreach($comments as $row)
        {
            // Retrieve the comment's updated_at value from the database
            $reviewCreated = $row["created_at"];
            $commentUpdated = $row["updated_at"];

            // Create a Carbon instance from the updated_at value
            $reviewCreated = Carbon::parse($reviewCreated);
            $commentUpdated = Carbon::parse($commentUpdated);

            // Calculate the time difference in hours or days from the current time
            $timeDiff_review = $reviewCreated->diffForHumans();
            $timeDiff_comment = $commentUpdated->diffForHumans();

            $liked = '';
            if (Session::has('user')){
                $user_id = Session::get('user')['id'];
                if($row['likes'] != NULL){
                    $likes = json_decode($row['likes'], true);
                    $user_index = array_search($user_id, $likes['users_id']);
                    if($user_index !== false){
                        $liked = 'YES';
                    } 
                }
            }
            
            $num_likes = 0;
            if($row['likes'] != NULL){
                $likes = json_decode($row['likes'], true);
                // Count the number of likes
                $num_likes = count($likes['users_id']); 
            }


            $review_content[] = array(
                'review_id'     =>  $row['id'],
                'user_name'		=>	$row["user_name"],
                'user_image'	=>	$row["user_image"],
                'user_review'	=>	$row["review"],
                'review_image'  =>  $row["image"],
                'rating'		=>	$row["rating"],
                'comment'		=>	$row["comment"],
                'reviewTime'	=>	$timeDiff_review,
                'commentTime'	=>	$timeDiff_comment,
                'liked'         =>  $liked,
                'num_likes'     =>  $num_likes
            );

            if($row["rating"] == '5')
            {
                $five_star_review++;
            }

            if($row["rating"] == '4')
            {
                $four_star_review++;
            }

            if($row["rating"] == '3')
            {
                $three_star_review++;
            }

            if($row["rating"] == '2')
            {
                $two_star_review++;
            }

            if($row["rating"] == '1')
            {
                $one_star_review++;
            }

            $total_review++;

            $total_user_rating = $total_user_rating + $row["rating"];

        }

        $average_rating = $total_user_rating / $total_review;

        $output = array(
            'average_rating'	=>	number_format($average_rating, 1),
            'total_review'		=>	$total_review,
            'five_star_review'	=>	$five_star_review,
            'four_star_review'	=>	$four_star_review,
            'three_star_review'	=>	$three_star_review,
            'two_star_review'	=>	$two_star_review,
            'one_star_review'	=>	$one_star_review,
            'review_data'		=>	$review_content
        );

        return view('user/review', compact('output'));
    }

    public function like($reviewId){
        $comment = $this->reviewRepository->findReview($reviewId);
        $user_id = Session::get('user')['id'];
        if($comment->likes != NULL){
            $likes = json_decode($comment->likes, true);
            $user_index = array_search($user_id, $likes['users_id']);
            if($user_index !== false){
                array_splice($likes['users_id'], $user_index, 1);
            } else {
                $likes['users_id'][] = $user_id;
            }
            // Count the number of likes
            $num_likes = count($likes['users_id']); 
            $response = array('num_likes' => $num_likes);
        }else{
            $likes = array(
                'users_id'  =>  array($user_id)
            );
            $response = array('num_likes' => '1');
        }
        $this->reviewRepository->updateLikes(json_encode($likes), $reviewId);
        return json_encode($response);
    }

    public function commentAnalysis_report()
    {
        $comments = Comment::select('id', 'rating', DB::raw('IFNULL(JSON_LENGTH(JSON_EXTRACT(likes, "$.users_id")), 0) as num_likes'))
        ->orderBy('id')
        ->get();

        // return $comments;
        return view('admin/report-commentAnalysis', compact('comments'));
    }
}
