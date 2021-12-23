#!bin/bash

#use this script only on master branch
branch="main"

#get last tag release
git checkout $branch
git fetch
git fetch --tags

git add -A
git commit -m "One"
git commit -m "Two with space"

#get git elements
repo=$(git config --get remote.origin.url | sed 's/git@github.com://' | sed 's/.git//')
token=$(git config --global user.token)
release=$(git for-each-ref --sort=creatordate --format '%(refname)' refs/tags | tail -1)


#get last tag
tag=$(echo $release | sed -r 's/refs\/tags\///g')
echo "Last Tag/Release found:" $tag

#create new tag
IFS='.' read -ra tags <<< "$tag"

last=${tags[-1]}
i=$((last+1))

tagNew=$(echo $tag | sed -r "s/\.$last/\.$i/g")
echo "New tag: $tagNew"

#tag verification or manual update
while true; do
    read -p ">> Do you want use this new tag? [y/n] " yn
    case $yn in
        [Yy]* ) break;;
        [Nn]* ) read -p "Please enter the new tag value: " tagNew; break;;
        * ) echo "Please answer yes or no.";;
    esac
done

echo "> We use this tag: $tagNew"

#update master branch with dev code
git pull origin dev --no-edit
git push origin $branch

#get last commits
message=$(git log $tag..HEAD --pretty=format:%s | grep -vi merge)

echo "> Messages:"
echo "$message"

#commits verification or manual update
while true; do
    read -p ">> Do you want use this messages? [y/n] " yn
    case $yn in
        [Yy]* ) break;;
        [Nn]* ) read -p "Please enter the new messages: " message; break;;
        * ) echo "Please answer yes or no.";;
    esac
done

echo "> We use this comments for new release:"
echo "$message"

#create tag on origin
git tag $tagNew
git push origin $tagNew

#create release on origin
echo "Create release $tagNew with message: $message"

curl -X POST https://api.github.com/repos/$repo/releases \
    -H "Content-Type:application/json" \
    -H "Authorization: token $token" \
    -d "{\"tag_name\":\"$tagNew\",\"name\":\"$tagNew\",\"body\":\"$message\"}"
