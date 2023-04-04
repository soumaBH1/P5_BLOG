<?php

function display_blogpost(array $bpost) : string
{
    $bpost_content = '';

   // if ($bpost['is_enabled']) {
        $bpost_content = '<article>';
        $bpost_content .= '<h3>' . $bpost['title'] . '</h3>';
        $bpost_content .= '<div>' . $bpost['recipe'] . '</div>';
        $bpost_content .= '<i>' . $bpost['author'] . '</i>';
        $bpost_content .= '</article>';
   // }
    
    return $bpost_content;
}

function display_author(string $authorEmail, array $users) : string
{
    for ($i = 0; $i < count($users); $i++) {
        $author = $users[$i];
        if ($authorEmail === $author['email']) {
            return $author['full_name'] . '(' . $author['age'] . ' ans)';
        }
    }

    return 'Non trouvé.';
}

function display_user(int $userId, array $users) : string
{
    for ($i = 0; $i < count($users); $i++) {
        $user = $users[$i];
        if ($userId === (int) $user['user_id']) {
            return $user['full_name'] . '(' . $user['age'] . ' ans)';
        }
    }

    return 'Non trouvé.';
}
//si admin
function display_user_admin(int $userId, array $users) : bool
{
    for ($i = 0; $i < count($users); $i++) {
        $user = $users[$i];
        if ($userId === (int) $user['user_id']) {
            return $user['admin'] ;
        }
    }

    return 0;
}

function retrieve_id_from_user_mail(string $userEmail, array $users) : int
{
    for ($i = 0; $i < count($users); $i++) {
        $user = $users[$i];
        if ($userEmail === $user['email']) {
            return $user['id'];
        }
    }

    return 0;
}

function get_bpost(array $bposts, int $limit) : array
{
    $valid_bposts = [];
    $counter = 0;

    foreach($bposts as $bpost) {
        if ($counter == $limit) {
            return $valid_bposts;
        }

        $valid_bposts[] = $bpost;
        $counter++;
    }

    return $valid_bposts;
}
?>