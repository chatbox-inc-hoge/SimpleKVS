# simpleKVS

スケーラブルなKVS機能

## 機能

- ドライバベースでストレージの種別を問わず使えるKVSモデル。
- データCRUDの抽象化。CRUD4種は一通り対応する。
- 直列化については考えない。SerializeとかJSONとか考えてたらInterfaceが冗長になる。

### 対象

- 他のテーブル系とJOINしないような独立したデータ群
- 頻繁に挿入がおき、KVS形式でのloadが行われるもの
- 揮発性データ群。
- 個々のデータ属性に応じた細かいKPIが不要な物。

- スケーラビリティを確保したくても、リーンスタートでRedisは冗長なので、
 　それ的な機能をDBで仮モック運用しつつ、あとで何とか的なやつ。

### ドライバの種類

必要に応じて追加していく

- DB(Eloquent) : Redis ライクに有効期限のサポート。論理削除

## Usage

````

$driver = new SimpleDB($config);

$kvs = new SimpleKVS($driver);

$model = $kvs->fetch($key);

echo $model->getKey();
echo $model->getValue();

$newValue = $kvs->set($newKey,$newValue);

$model->update($brandNewValue);
$model->delete();

````