<?php
$str = "data:image/png;base64,/9j/4AAQSkZJRgABAQEAYABgAAD//gA+Q1JFQVRPUjogZ2QtanBlZyB2MS4wICh1c2luZyBJSkcgSlBFRyB2ODApLCBkZWZhdWx0IHF1YWxpdHkK/9sAQwAIBgYHBgUIBwcHCQkICgwUDQwLCwwZEhMPFB0aHx4dGhwcICQuJyAiLCMcHCg3KSwwMTQ0NB8nOT04MjwuMzQy/9sAQwEJCQkMCwwYDQ0YMiEcITIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIy/8AAEQgAUAA9AwEiAAIRAQMRAf/EAB8AAAEFAQEBAQEBAAAAAAAAAAABAgMEBQYHCAkKC//EALUQAAIBAwMCBAMFBQQEAAABfQECAwAEEQUSITFBBhNRYQcicRQygZGhCCNCscEVUtHwJDNicoIJChYXGBkaJSYnKCkqNDU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6g4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2drh4uPk5ebn6Onq8fLz9PX29/j5+v/EAB8BAAMBAQEBAQEBAQEAAAAAAAABAgMEBQYHCAkKC//EALURAAIBAgQEAwQHBQQEAAECdwABAgMRBAUhMQYSQVEHYXETIjKBCBRCkaGxwQkjM1LwFWJy0QoWJDThJfEXGBkaJicoKSo1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoKDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uLj5OXm5+jp6vLz9PX29/j5+v/aAAwDAQACEQMRAD8A57fSbjUe73pC1YHYPJrhNa0SWPVXMCosMvzhncKq56jJrpb3WoLfKRkSyeg6D6muT1e6nvZUkkbIHRR0FXG9zGo00V7jRb+2gM5g8yAdZYXEij6lScfjVCrNteXWn3AmtZpIZB/EhxmtiOfStb+TUI10+8PS7gT925/20HT6j8qsyO38H+PPCHhrTVtIrG+jmYAzTlFZpG/766egrrB8TvB1ygMtxICOgktmJH5A14fqWgX2lFWnRXgf/V3ER3Rv9G/p1qhsNFi+drQ9CvNTt7MYkfL/ANxeTXPXmr3F3lc+XH/dXv8AU1mFyxJJyT3NJvqErDcmyXdTHORg0zdnvSU0hDGUcmlSIKN+fwPenUH0qyGaOm6/daZuhUJJbP8A6y1mXdG4+h/nWiLDw3qv+kQag2lMfv28yGRQf9k56fWuaYb+tRkOOME0BclJpMg1HS0rDuaujaJe67ei2so9xHLufuoPevQbb4RhoAZr+Qyn+4oAB+ldT8KNCjTwvDcpHmS4Yu7Y59B+leo2+lJEm91ywHA/xrCUpX0PRp06MIJ1NWz5d8SeBtS8PBpc/aLZerqMFfqK5Wvq3W9KjmgkWRAQwJII7d6+Z/EWl/2VrtzaKMIrZQexq6c29GYYqjGKU4bGWBRjNPC08ADtWpxlGlB9aYD60A0AfQHwa1yG60IWBkxPasVK9yp5B/p+FezwzBYMAHH95hgV8U6Nrd9oGpJfWEuyVeoPIYehHpXsujfG3SJ7UR6xZXcMw6mHDqf1BrFxad0dftI1IJSeqPVdVkQxtgg55JPf/AV8x+ObyK78XXjQnckeI8juR1/Wu28UfFuG9s5LPw5YzRNICrXVzgMo/wBlRnn3J/CvLPIcZdySx5JPenCNndirVeaKghqjNPwaQUM3NanKZdKAaAOafQAU5DtYcUgHNPUZ60AaNvPGiZI5pZZTL06VRX0qVGO2lYdyTHBqNQz85qwAdvY5p4QAcCmI/9k=";


$type = "png";
                        
list($header, $imageBase64) = explode(',', $str); //notData=data:image/png;base64, imageBase64=image
list($fullImageType, ) = explode(';', $header); //fullImageType = remove base64
list(, $type ) = explode('/', $fullImageType); //type = get png/jpg/gif



//data:image/png;base64,
if (preg_match('/^data:image\/(\w+);base64/', $header)) {
    

    if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
        throw new \Exception('invalid image type');
    } else{
       echo -1; // echo "image is of allowed type.\n\n";
    }

    $imageBase64 = base64_decode($imageBase64);

    if ($imageBase64 === false) {
        throw new \Exception('base64_decode failed');
    } else{
        echo $imageBase64;//echo "image was successfully decoded.\n\n";
    }
}else{
    echo $header;
}                

?>