<?php
if($_SERVER["REQUEST_METHOD"] == "GET"){

    try{
        require_once "db_conn.php";
        $query = "SELECT * FROM comments ORDER BY id DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pdo  = null;
        $stmt = null;
    }
    catch(PDOException $e){
        die("Bad query:" .$e->getMessage());
    }
}

function sortComments($comments) {
    $sortedComments = [];

    $tempReplies = [];

    // Organize replies by parent_id
    foreach ($comments as $comment) {
        if ($comment['parent_id'] === null) {
            // Add top-level comment to sortedComments
            $comment['childrenReplies'] = [];
            $sortedComments[$comment['id']] = $comment;
        } else {
            // Organize replies by their parent_id
            $tempReplies[$comment['parent_id']][] = $comment;
        }
    }

    // Assign replies to their respective parent comments
    foreach ($sortedComments as &$parentComment) {
        if (isset($tempReplies[$parentComment['id']])) {
            $parentComment['childrenReplies'] = $tempReplies[$parentComment['id']];
        }
    }

    return array_values($sortedComments); // Reset array keys and return
}

    function formatDate($date) {
        $dateObject = DateTime::createFromFormat('Y-m-d', $date);

        if (!$dateObject) {
            return "Invalid date format!";
        }

        return $dateObject->format('Y M d');
    }

    function rendercomment($comments,$count)
    {

        echo '<h4 class="mt-3 d-flex justify-content-center" >'. $count . ' Comments</h4>';
         foreach ($comments as $comment) {
        // Parent comment

        echo '<div class="">';
        echo '<div class="bg-light container-md">';
            echo '<div class="media-body ">';
             echo "<div class='d-flex justify-content-between p-3'>";
                // Name and Email
                echo '<h5 class="mt-0">';
                    echo htmlspecialchars($comment["name"]);
                    echo '<small class="text-muted ml-2">' . formatDate(htmlspecialchars($comment["date"])) . '</small>';
                echo '</h5>';
             // Reply button
             echo '<div>';
             echo '<i class="bi bi-send"></i>';
             echo '<button class="btn  btn-info reply-btn ml-2" data-commentid="' . $comment['id'] . '">Reply</button>';

             echo '</div>';
             echo "</div>";

             // Comment Content
                echo '<p class="ml-3">' . htmlspecialchars($comment["content"]) . '</p>';

                echo '</div>';

                // Check if there are child replies
                if (!empty($comment['childrenReplies'])) {
                    echo '<div class="ml-4 mt-3 ">';

                    foreach ($comment['childrenReplies'] as $reply) {
                        echo '<div class="media mb-3 p-3 border border-secondary rounded">';
                            echo '<div class="media-body">';
                                echo '<h6 class="mt-0">';
                                    echo htmlspecialchars($reply["name"]);
                                    echo '<small class="text-muted ml-2">' . formatDate(htmlspecialchars($comment["date"])) . '</small>';
                                echo '</h6>';

                                echo '<p>' . htmlspecialchars($reply["content"]) . '</p>';
                            echo '</div>';
                        echo '</div>';
                    }

                    echo '</div>'; // End of child replies
                }
            echo '</div>';
        echo '</div>';

        }// End of parent comment
    }

        if (empty($results)) {
            echo "<div>";
            echo "<p> No Comments !</p>";
            echo "</div>";
        } else {

            rendercomment(sortComments($results), sizeof($results));

    }
    ?>
